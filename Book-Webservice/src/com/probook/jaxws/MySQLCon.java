package com.probook.jaxws;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.sql.*;

class MySQLCon {
    private String dbName = "";
    private String username = "";
    private String password = "";
    private final String port = "3306";

    public MySQLCon() {
        File file = new File("./data/config.txt");
        try {
            BufferedReader br = new BufferedReader(new FileReader(file));
            dbName = br.readLine();
            username = br.readLine();
            password = br.readLine();
        } catch (Exception e) {
            System.out.println("Error reading file");
        }
    }

    public Connection connectDB() throws Exception{
        Class.forName("com.mysql.jdbc.Driver");
        Connection con = DriverManager.getConnection(
                "jdbc:mysql://localhost:" + port + "/" + dbName, username, password);
        return con;
    }

    /**
     * Query Tester
     * @param query
     */
    public void selectQuery(String query) {
        try{
            Connection con = connectDB();
            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery(query);
            while (rs.next())
                System.out.println(rs.getString(1)+"  "+rs.getString(2)+"  "+rs.getString(3));
            con.close();
        } catch (Exception e){
            System.out.println(e);
        }
    }

    public static void main(String[] args) {
        MySQLCon conn = new MySQLCon();
        conn.selectQuery("SELECT * FROM buku");
    }
}
