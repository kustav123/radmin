import sqlite3

def migrate():
    con = sqlite3.connect("infra_provisioner.db")
    cur = con.cursor()
    try:
        cur.execute("ALTER TABLE db_instances ADD COLUMN namespace VARCHAR;")
        print("Column 'namespace' added successfully.")
    except sqlite3.OperationalError as e:
        if "duplicate column name: namespace" in str(e):
            print("Column 'namespace' already exists.")
        else:
            print(f"Error: {e}")
    con.commit()
    con.close()

if __name__ == "__main__":
    migrate()
