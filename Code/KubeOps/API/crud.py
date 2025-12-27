from sqlalchemy.orm import Session
import models, security


def get_user_by_username(db: Session, username: str):
    return db.query(models.User).filter(models.User.username == username).first()


def get_user_by_id(db: Session, user_id: int):
    return db.query(models.User).filter(models.User.id == user_id).first()


def create_user(db: Session, username: str, email: str, password: str, role: str = "user"):
    if password is None:
        raise ValueError("Password is required")
    # Use security.get_password_hash (now Argon2 by default)
    hashed = security.get_password_hash(password)
    user = models.User(username=username, email=email, password_hash=hashed, role=role)
    db.add(user)
    db.commit()
    db.refresh(user)
    return user


def get_workers(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Worker).offset(skip).limit(limit).all()


def create_worker(db: Session, name: str, image_url: str, type_: str):
    w = models.Worker(name=name, image_url=image_url, type=type_)
    db.add(w)
    db.commit()
    db.refresh(w)
    return w


def get_jobs(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Job).offset(skip).limit(limit).all()


def create_job(db: Session, name: str, namespace: str, worker_id: int, arguments, service_account_id: int = None,
               completions: int = None, parallelism: int = None, backoff_limit: int = 6,
               active_deadline_seconds: int = None, ttl_seconds_after_finished: int = None,
               restart_policy: str = "Never", image: str = None, command: list = None, args: list = None,
               env_vars: dict = None, resources: dict = None, volumes: list = None, volume_mounts: list = None,
               image_pull_secrets: list = None, labels: dict = None, annotations: dict = None):
    # Fetch worker to get the image URL
    worker = db.query(models.Worker).filter(models.Worker.id == worker_id).first()
    if not worker:
        raise ValueError(f"Worker with id {worker_id} not found")
    
    # Use worker's image_url if no image is provided
    job_image = image if image else worker.image_url
    
    j = models.Job(
        name=name,
        namespace=namespace,
        worker_id=worker_id,
        service_account_id=service_account_id,
        arguments=arguments,
        completions=completions,
        parallelism=parallelism,
        backoff_limit=backoff_limit,
        active_deadline_seconds=active_deadline_seconds,
        ttl_seconds_after_finished=ttl_seconds_after_finished,
        restart_policy=restart_policy,
        image=job_image,
        command=command,
        args=args,
        env_vars=env_vars,
        resources=resources,
        volumes=volumes,
        volume_mounts=volume_mounts,
        image_pull_secrets=image_pull_secrets,
        labels=labels,
        annotations=annotations
    )
    db.add(j)
    db.commit()
    db.refresh(j)
    return j


def get_serviceaccounts(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.ServiceAccount).offset(skip).limit(limit).all()


def get_serviceaccount_by_id(db: Session, sa_id: int):
    return db.query(models.ServiceAccount).filter(models.ServiceAccount.id == sa_id).first()


def create_serviceaccount(db: Session, name: str):
    sa = models.ServiceAccount(name=name)
    db.add(sa)
    db.commit()
    db.refresh(sa)
    return sa


def delete_serviceaccount(db: Session, sa_id: int):
    sa = get_serviceaccount_by_id(db, sa_id)
    if not sa:
        return None
    db.delete(sa)
    db.commit()
    return sa


def get_or_create_admin(db: Session, username: str, email: str, password: str):
    """Idempotent helper to ensure an admin user exists.

    Returns the existing or newly created user.
    """
    user = get_user_by_username(db, username)
    if user:
        return user
    # create user
    return create_user(db, username=username, email=email, password=password, role="admin")


def update_user_password(db: Session, user_id: int, new_password: str):
    user = get_user_by_id(db, user_id)
    if not user:
        raise ValueError("User not found")
    if new_password is None or new_password == "":
        raise ValueError("New password is required")
    hashed = security.get_password_hash(new_password)
    user.password_hash = hashed
    db.add(user)
    db.commit()
    db.refresh(user)
    return user


def update_user_role(db: Session, user_id: int, new_role: str):
    user = get_user_by_id(db, user_id)
    if not user:
        raise ValueError("User not found")
    if not new_role:
        raise ValueError("Role is required")
    user.role = new_role
    db.add(user)
    db.commit()
    db.refresh(user)
    return user
