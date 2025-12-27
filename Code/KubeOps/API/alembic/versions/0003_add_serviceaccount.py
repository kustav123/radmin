"""add serviceaccount table

Revision ID: 0003_add_serviceaccount
Revises: 0002_seed_admin
Create Date: 2025-12-28
"""
from alembic import op
import sqlalchemy as sa

revision = '0003_add_serviceaccount'
down_revision = '0002_seed_admin'
branch_labels = None
depends_on = None


def upgrade():
    op.create_table(
        'serviceaccount',
        sa.Column('id', sa.Integer(), primary_key=True),
        sa.Column('name', sa.String(length=255), nullable=False, unique=True),
        sa.Column('created_at', sa.DateTime(), server_default=sa.func.now()),
        sa.Column('updated_at', sa.DateTime(), server_default=sa.func.now(), onupdate=sa.func.now()),
    )


def downgrade():
    op.drop_table('serviceaccount')
