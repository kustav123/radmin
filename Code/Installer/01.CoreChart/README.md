# Core Umbrella Chart

A Helm umbrella chart for all core services and operators, including CloudNativePG and Strimzi Kafka Operator.

## Prerequisites

- [Helm](https://helm.sh/docs/intro/install/) v3+
- Kubernetes cluster v1.21+

## Chart Dependencies

Before installing or upgrading the chart, ensure you have the required subcharts downloaded:

```bash
helm dependency update
```

## Installation

To install the chart with the name `core-chart` in the `default` namespace:

```bash
helm upgrade --install core-chart .
```

To install in a specific namespace:

```bash
helm upgrade --install core-chart . -n <namespace> --create-namespace
```

## Configuration

The following table lists the configurable parameters of the Core Umbrella Chart and their default values.

### Subchart Toggles

| Parameter | Description | Default |
| --------- | ----------- | ------- |
| `cloudnative-pg.enabled` | Enable CloudNativePG operator | `true` |
| `cloudnative-pg.crds.create` | Whether to create CNPG CRDs | `true` |
| `strimzi-kafka-operator.enabled` | Enable Strimzi Kafka operator | `true` |
| `waitJob.image.repository` | Repository for the readiness check job | `bitnami/kubectl` |
| `waitJob.image.tag` | Tag for the readiness check job image | `latest` |

### Service Configuration

#### CloudNativePG
- **Image**: `ghcr.io/cloudnative-pg/cloudnative-pg:1.28.1`
- **Node Selector**: Disabled by default. Can be enabled by providing a `role` or other matching labels.

#### Strimzi Kafka Operator
- **Image**: `quay.io/strimzi/operator:0.51.0`
- **Node Selector**: Disabled by default.

### Customizing Values

You can override any value in `values.yaml` using the `--set` flag or by providing your own values file:

```bash
# Disable Strimzi and set custom CNPG image
helm upgrade --install core-chart . \
  --set strimzi-kafka-operator.enabled=false \
  --set cloudnative-pg.image.tag=1.27.1
```

Or using a custom file:

```bash
helm upgrade --install core-chart . -f my-values.yaml
```
