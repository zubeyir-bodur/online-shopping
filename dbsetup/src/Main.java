import java.sql.*;

public class Main {
    public static void main(String[] args) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
        }
        catch(ClassNotFoundException cnfe) {
            System.out.println("JDBC Driver was not found!");
        }
        Connection connection = MySQLConnection.connect("jdbc:mysql://localhost:3306/database_name?allowMultiQueries=true",
                "root", "");
        if (connection != null) {
            // There is no output for DDL commands
            DDL.createTables(connection);

            // Seed the database
            Seed.seed(connection);

            // Execute the queries and print their output in console
            System.out.println("The birth dates, addresses and " +
                    "cities of the customers who has" +
                    " the minimum amount of money in his/her wallet: ");
            Query.query1(connection);
            System.out.println();
            System.out.println("Give the names of the customers who bought" +
                    " all products whose price is less " +
                    "than 10: ");
            Query.query2(connection);
            System.out.println();
            System.out.println("Give the names of the products who" +
                    " are bought by at least 3 different " +
                    "customers: ");
            Query.query3(connection);
            System.out.println();
            System.out.println("Give the names of the products " +
                    " which can be bought by the youngest customer " +
                    " with his/her money in the wallet: ");
            Query.query4(connection);
            System.out.println();
            System.out.println("Give the name of the customer who " +
                    "spent the maximum money: ");
            Query.query5(connection);
        }
    }
}
