"""add service_account_id to job

Revision ID: 0004_add_job_serviceaccount
Revises: 0003_add_serviceaccount
Create Date: 2025-12-28
"""
from alembic import op
import sqlalchemy as sa

revision = '0004_add_job_serviceaccount'
down_revision = '0003_add_serviceaccount'
branch_labels = None
depends_on = None


def upgrade():
    op.add_column('job', sa.Column('service_account_id', sa.Integer(), sa.ForeignKey('serviceaccount.id'), nullable=True))


def downgrade():
    op.drop_column('job', 'service_account_id')
