import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;

public class Seed {
    /**
     * Seeds the table with the data given in hw4
     * Deletes all the previous data if exists
     * @param con
     */
    public static void seed(Connection con) {
        try {
            Statement seed = con.createStatement();
            // Seeding Query goes here
            seed.executeUpdate("DELETE FROM customer;" +
                    "INSERT INTO customer VALUES" +
                    "                    ('C101', 'Ali',STR_TO_DATE('03.03.1997', '%d.%m.%Y'), 'Besiktas', 'Istanbul', 114.50)," +
                    "                    ('C102', 'Veli',STR_TO_DATE('19.05.2001', '%d.%m.%Y'), 'Bilkent', 'Ankara', 200.00)," +
                    "                    ('C103', 'Ayse',STR_TO_DATE('23.04.1972', '%d.%m.%Y'), 'Tunali', 'Ankara', 15.00)," +
                    "                    ('C104', 'Alice',STR_TO_DATE('29.10.1990', '%d.%m.%Y'), 'Meltem', 'Antalya', 1024.00)," +
                    "                    ('C105', 'Bob',STR_TO_DATE('30.08.1987', '%d.%m.%Y'), 'Stretford', 'Manchester', 15.00);" +
                    "DELETE FROM product;" +
                    "INSERT INTO product VALUES" +
                    "                    ('P101', 'powerbank', 300.00, 2)," +
                    "                    ('P102', 'battery', 5.50, 5)," +
                    "                    ('P103', 'laptop', 3500.00, 10)," +
                    "                    ('P104', 'mirror', 10.75, 50)," +
                    "                    ('P105', 'notebook', 3.85, 100)," +
                    "                    ('P106', 'carpet', 50.99, 1)," +
                    "                    ('P107', 'lawn mower', 1025.00, 3);" +
                    "DELETE FROM buy;" +
                    "INSERT INTO buy VALUES" +
                    "                    ('C101', 'P105', 2)," +
                    "                    ('C102', 'P105', 2)," +
                    "                    ('C103', 'P105', 5)," +
                    "                    ('C101', 'P101', 1)," +
                    "                    ('C102', 'P102', 4)," +
                    "                    ('C105', 'P104', 1);");
        } catch (Exception e)  {
            e.printStackTrace();
        }
    }
}
