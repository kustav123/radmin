"""add kubernetes job parameters

Revision ID: 0005_add_k8s_job_params
Revises: 0004_add_job_serviceaccount
Create Date: 2025-12-28
"""
from alembic import op
import sqlalchemy as sa

revision = '0005_add_k8s_job_params'
down_revision = '0004_add_job_serviceaccount'
branch_labels = None
depends_on = None


def upgrade():
    # Kubernetes Job Spec Parameters
    op.add_column('job', sa.Column('completions', sa.Integer(), nullable=True))
    op.add_column('job', sa.Column('parallelism', sa.Integer(), nullable=True))
    op.add_column('job', sa.Column('backoff_limit', sa.Integer(), nullable=True, server_default='6'))
    op.add_column('job', sa.Column('active_deadline_seconds', sa.Integer(), nullable=True))
    op.add_column('job', sa.Column('ttl_seconds_after_finished', sa.Integer(), nullable=True))
    
    # Pod Template Parameters
    op.add_column('job', sa.Column('restart_policy', sa.String(length=50), nullable=True, server_default='Never'))
    op.add_column('job', sa.Column('image', sa.String(length=500), nullable=True))
    op.add_column('job', sa.Column('command', sa.JSON(), nullable=True))
    op.add_column('job', sa.Column('args', sa.JSON(), nullable=True))
    op.add_column('job', sa.Column('env_vars', sa.JSON(), nullable=True))
    op.add_column('job', sa.Column('resources', sa.JSON(), nullable=True))
    op.add_column('job', sa.Column('volumes', sa.JSON(), nullable=True))
    op.add_column('job', sa.Column('volume_mounts', sa.JSON(), nullable=True))
    op.add_column('job', sa.Column('image_pull_secrets', sa.JSON(), nullable=True))
    
    # Metadata
    op.add_column('job', sa.Column('labels', sa.JSON(), nullable=True))
    op.add_column('job', sa.Column('annotations', sa.JSON(), nullable=True))


def downgrade():
    # Remove Kubernetes Job Spec Parameters
    op.drop_column('job', 'completions')
    op.drop_column('job', 'parallelism')
    op.drop_column('job', 'backoff_limit')
    op.drop_column('job', 'active_deadline_seconds')
    op.drop_column('job', 'ttl_seconds_after_finished')
    
    # Remove Pod Template Parameters
    op.drop_column('job', 'restart_policy')
    op.drop_column('job', 'image')
    op.drop_column('job', 'command')
    op.drop_column('job', 'args')
    op.drop_column('job', 'env_vars')
    op.drop_column('job', 'resources')
    op.drop_column('job', 'volumes')
    op.drop_column('job', 'volume_mounts')
    op.drop_column('job', 'image_pull_secrets')
    
    # Remove Metadata
    op.drop_column('job', 'labels')
    op.drop_column('job', 'annotations')
