import os
from kubernetes import client, config as k8s_config
from config import settings

class K8sClient:
    def __init__(self):
        if settings.IN_CLUSTER:
            k8s_config.load_incluster_config()
        else:
            k8s_config.load_kube_config()
        
        self.custom_objects_api = client.CustomObjectsApi()
        self.core_api = client.CoreV1Api()

    def create_cnpg_cluster(self, 
                             name: str, 
                             namespace: str, 
                             instances: int, 
                             storage_size: str, 
                             storage_class: str, 
                             cpu_request: str, 
                             mem_request: str, 
                             cpu_limit: str, 
                             mem_limit: str,
                             db_name: str,
                             owner: str,
                             password: str,
                             root_password: str = None,
                             nodeport: int = None):
        
        # CNPG Cluster Manifest
        cluster_manifest = {
            "apiVersion": "postgresql.cnpg.io/v1",
            "kind": "Cluster",
            "metadata": {
                "name": name,
                "namespace": namespace
            },
            "spec": {
                "instances": instances,
                "imageName": "ghcr.io/cloudnative-pg/postgresql:16",
                "storage": {
                    "size": storage_size,
                    "storageClass": storage_class
                },
                "resources": {
                    "requests": {
                        "cpu": cpu_request,
                        "memory": mem_request
                    },
                    "limits": {
                        "cpu": cpu_limit,
                        "memory": mem_limit
                    }
                },
                "bootstrap": {
                    "initdb": {
                        "database": db_name,
                        "owner": owner,
                        "secret": {
                            "name": f"{name}-app-auth"
                        }
                    }
                }
            }
        }

        # Handle Superuser Secret
        if root_password:
            self.create_auth_secret(f"{name}-superuser", namespace, "postgres", root_password)
            cluster_manifest["spec"]["superuserSecret"] = {
                "name": f"{name}-superuser"
            }

        # Handle built-in NodePort if requested
        if nodeport:
            cluster_manifest["spec"]["managed"] = {
                "services": {
                    "additional": [
                        {
                            "selectorType": "rw", # Read/Write points to primary
                            "serviceTemplate": {
                                "metadata": {
                                    "name": f"{name}-nodeport"
                                },
                                "spec": {
                                    "type": "NodePort",
                                    "ports": [
                                        {
                                            "name": "postgres",
                                            "port": 5432,
                                            "targetPort": 5432,
                                            "nodePort": nodeport
                                        }
                                    ]
                                }
                            }
                        }
                    ]
                }
            }

        # Create Secret for App Auth
        self.create_auth_secret(f"{name}-app-auth", namespace, owner, password)

        # Create Cluster Object
        return self.custom_objects_api.create_namespaced_custom_object(
            group="postgresql.cnpg.io",
            version="v1",
            namespace=namespace,
            plural="clusters",
            body=cluster_manifest
        )

    def create_auth_secret(self, name, namespace, username, password):
        import base64
        body = client.V1Secret(
            metadata=client.V1ObjectMeta(name=name),
            type="kubernetes.io/basic-auth",
            string_data={
                "username": username,
                "password": password
            }
        )
        try:
            self.core_api.create_namespaced_secret(namespace=namespace, body=body)
        except client.exceptions.ApiException as e:
            if e.status == 409: # Conflict - already exists
                pass
            else:
                raise e

    def get_cluster_status(self, name, namespace):
        try:
            cluster = self.custom_objects_api.get_namespaced_custom_object(
                group="postgresql.cnpg.io",
                version="v1",
                namespace=namespace,
                plural="clusters",
                name=name
            )
            return cluster.get("status", {}).get("phase", "Unknown")
        except:
            return "Not Found"
