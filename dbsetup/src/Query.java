import java.sql.*;
import java.util.ArrayList;

public class Query {
    /**
     * Give the birth dates, addresses and cities of the customers who has the
     * minimum amount money in his/her wallet.
     * @param con
     * @return
     */
    public static void query1(Connection con) {
        try {
            Statement query = con.createStatement();
            // Query goes here
            ResultSet resultSet = query.executeQuery("SELECT c1.cname, c1.bdate, c1. address, c1.city, c1.wallet " +
                    "FROM customer as c1 " +
                    "WHERE c1.wallet <= all(SELECT c2.wallet FROM customer as c2);");
            /*
            System.out.println("Customer Name" + "\t" +
                    "Birth Date" + "\t" +
                    "Address" + "\t" +
                    "City" + "\t" +
                    "Wallet");
            while (resultSet.next()) {
                String customerName = resultSet.getString("cname");
                Date birthDate = resultSet.getDate("bdate");
                String address = resultSet.getString("address");
                String city = resultSet.getString("city");
                float wallet = resultSet.getFloat("wallet");
                System.out.println(customerName + "\t" + birthDate + "\t" + address +
                        "\t" + city + "\t" + wallet);
            }
            */
            printResultSet(resultSet);
        } catch (Exception e)  {
            e.printStackTrace();
        }
    }

    /**
     * Give the names of the customers who bought all products whose price is less
     * than 10.
     * @param con
     * @return
     */
    public static void query2(Connection con) {
        try {
            Statement query = con.createStatement();
            // Query goes here
            ResultSet resultSet = query.executeQuery("SELECT cname\n" +
                    "FROM customer as c1\n" +
                    "WHERE c1.cid IN(\n" +
                    "\t/*buy divided by product<10*/\n" +
                    "    SELECT DISTINCT b1.cid as cid\n" +
                    "    FROM buy as b1\n" +
                    "    WHERE NOT EXISTS(\n" +
                    "\t\tSELECT plt10.pid\n" +
                    "        FROM (SELECT p1.pid \n" +
                    "          FROM product AS p1\n" +
                    "\t\t  WHERE p1.price < 10) as plt10\n" +
                    "\t\tWHERE plt10.pid NOT IN(\n" +
                    "\t\t\tSELECT b2.pid\n" +
                    "            FROM buy as b2\n" +
                    "            WHERE b2.cid = b1.cid)\n" +
                    "        )\n" +
                    "    );");
//            while (resultSet.next()) {
//
//            }
            printResultSet(resultSet);
        } catch (Exception e)  {
            e.printStackTrace();
        }
    }

    /**
     * Give the names of the products who are bought by at least 3 different
     * customers
     * @param con
     * @return
     */
    public static void query3(Connection con) {
        try {
            Statement query = con.createStatement();
            // Query goes here
            ResultSet resultSet = query.executeQuery("SELECT pname " +
                    "FROM product as p1 " +
                    "WHERE p1.pid in(SELECT DISTINCT b1.pid " +
                                    "FROM buy as b1 " +
                                    "GROUP BY pid " +
                                    "HAVING COUNT(*) >= 3);");
//            while (resultSet.next()) {
//
//            }
            printResultSet(resultSet);
        } catch (Exception e)  {
            e.printStackTrace();
        }
    }

    /**
     * Give the names of the products which can be bought by the youngest customer
     * with his/her money in the wallet.
     * @param con
     * @return
     */
    public static void query4(Connection con) {
        try {
            Statement query = con.createStatement();
            // Query goes here
            ResultSet resultSet = query.executeQuery(
                    "SELECT pname " +
                    "FROM product " +
                    "WHERE price <= (SELECT c1.wallet " +
                                    "FROM customer as c1 " +
                                    "WHERE c1.bdate >= all(SELECT c2.bdate " +
                                                            "FROM customer as c2 " +
                                                            "WHERE c1.cid <> c2.cid));");
//            while (resultSet.next()) {
//
//            }
            printResultSet(resultSet);
        } catch (Exception e)  {
            e.printStackTrace();
        }
    }

    /**
     * Give the name of the customer who spent the maximum money
     * @param con
     * @return
     */
    public static void query5(Connection con) {
        try {
            Statement query = con.createStatement();
            // Query goes here
            ResultSet resultSet = query.executeQuery("WITH spendings(cid, spending) as(" +
                    "SELECT cid, SUM(price*quantity) as spending " +
                    "FROM buy INNER JOIN product on buy.pid = product.pid " +
                    "GROUP BY cid)" +
                    "SELECT cname " +
                    "FROM spendings INNER JOIN customer on spendings.cid = customer.cid " +
                    "WHERE spending >= all(SELECT s1.spending " +
                    "FROM spendings as s1);");
            printResultSet(resultSet);
        } catch (Exception e)  {
            e.printStackTrace();
        }
    }

    private static void printResultSet(ResultSet rs) {
        try{
            ResultSetMetaData rsmd = rs.getMetaData();
            int numColumns = rsmd.getColumnCount();
            ArrayList<String> attributes = new ArrayList<>();
            for (int i = 1; i <= numColumns; i++) {
                String a = rsmd.getColumnName(i);
                attributes.add(a);
                System.out.print(a + "\t");
            }
            System.out.println();
            while (rs.next()) {
                for (int i = 1; i <= numColumns; i++){
                    System.out.print(rs.getObject(attributes.get(i-1)) + "\t");
                }
                System.out.println();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
