"""seed admin user

Revision ID: 0002_seed_admin
Revises: 0001_initial
Create Date: 2025-12-14
"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy import text

revision = '0002_seed_admin'
down_revision = '0001_initial'
branch_labels = None
depends_on = None


def upgrade():
    # Idempotently insert an admin user with a hashed password.
    # We compute the bcrypt hash at migration runtime to avoid storing plaintext in VCS.
    conn = op.get_bind()
    res = conn.execute(text("SELECT 1 FROM users WHERE username = :u"), {"u": "admin"}).fetchone()
    if res:
        return

    # Precomputed Argon2id hash for password 'kubeops'.
    # Generated locally with argon2-cffi PasswordHasher(); keep in mind this value grants access if leaked.
    prehashed = '$argon2id$v=19$m=65536,t=3,p=4$r/I4jxkNCjdR63ldpfaQoQ$+wdQGkCVwHGDlcEHcoX5RIdRp4VbMAX56WxvE34NW0Q'
    conn.execute(
        text("INSERT INTO users (username,email,password_hash,role) VALUES (:u,:e,:p,:r)"),
        {"u": "admin", "e": "admin@example.com", "p": prehashed, "r": "admin"},
    )


def downgrade():
    conn = op.get_bind()
    conn.execute(text("DELETE FROM users WHERE username = :u"), {"u": "admin"})
