import java.sql.*;
public class MySQLConnection {
    public static Connection connect(String url, String user, String password) {
        try {
            return DriverManager.getConnection(url,user,password);
        } catch(SQLException e){
            System.out.println("Connection was not successful, Error Code: " +
                    e.getErrorCode() + ", Message : " + e.getMessage() );
            return null;
        }
    }
}
