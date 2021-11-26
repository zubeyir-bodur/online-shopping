import java.sql.*;
public class DDL {
    /**
     * Drop buy, customer and product tables if they exist
     * Then recreate
     * @param con
     */
    public static void createTables(Connection con) {
        try {
            Statement ddl = con.createStatement();
            // DDL Query goes here
            // if the tables exist, drop them
            ddl.executeUpdate("DROP TABLE IF EXISTS buy;\n" +
                    "DROP TABLE IF EXISTS customer;\n" +
                    "DROP TABLE IF EXISTS product;\n" +
                    "CREATE TABLE customer(\n" +
                    "                    cid CHAR(12),\n" +
                    "                    cname VARCHAR(50),\n" +
                    "                    bdate DATE,\n" +
                    "                    address VARCHAR(50),\n" +
                    "                    city VARCHAR(20),\n" +
                    "                    wallet FLOAT,\n" +
                    "                    PRIMARY KEY(cid));\n" +
                    "CREATE TABLE product(\n" +
                    "\tpid CHAR(8),\n" +
                    "\tpname VARCHAR(20),\n" +
                    "\tprice FLOAT,\n" +
                    "\tstock INT,\n" +
                    "\tPRIMARY KEY(pid) );\n" +
                    "CREATE TABLE buy(\n" +
                    "\t\t\t\t\tcid CHAR(12),\n" +
                    "                    pid CHAR(8),\n" +
                    "                    quantity INT,\n" +
                    "                    PRIMARY KEY CLUSTERED(cid, pid, quantity),\n" +
                    "                    FOREIGN KEY(cid) REFERENCES customer(cid) ON DELETE CASCADE,\n" +
                    "                    FOREIGN KEY(pid) REFERENCES product(pid) ON DELETE CASCADE);");
        } catch (Exception e)  {
            e.printStackTrace();
        }
    }
}
