package com.probook.jaxws;

import com.googlebooks.api.Buku;
import com.googlebooks.api.GoogleBookClient;

import javax.jws.WebService;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.Random;

//Service Implementation
@WebService(endpointInterface = "com.probook.jaxws.BookService")
public class BookServiceImpl implements BookService{

    @Override
    public String getHelloWorldString(String name) {
        return "Hello World From BookService, " + name;
    }

    @Override
    public boolean insertPurchase(String id_buku, int jml, String no_kartu) {
        MySQLCon mysql = new MySQLCon();
        String q1;
        try{
            Connection conn = mysql.connectDB();
            q1 = "INSERT INTO riwayat (id_buku, jumlah, no_rekening) VALUES (?, ?, ?)";
            PreparedStatement preparedStatement = conn.prepareStatement(q1);
            preparedStatement.setString(1, id_buku);
            preparedStatement.setInt(2, jml);
            preparedStatement.setString(3, no_kartu);
            preparedStatement.executeUpdate();
            conn.close();
            return true;
        } catch (Exception e){
            System.out.println(e);
            return false;
        }
    }

    @Override
    public SOAPResponse searchBooks(String input) {
        MySQLCon mysql = new MySQLCon();
        SOAPResponse response = new SOAPResponse();
        ArrayList<Buku> books;

        GoogleBookClient gBook = new GoogleBookClient();
        books = gBook.searchBookByTitle(input);

        //Insert Books ID and price into Database
        try{
            Connection conn = mysql.connectDB();
            String query;
            for (Buku buku: books) {
                query = "INSERT INTO buku (id_buku, harga) VALUES (?, ?)";
                PreparedStatement ps = conn.prepareStatement(query);
                ps.setString(1, buku.getIdBuku());
                ps.setInt(2, buku.getHarga());
                ps.executeUpdate();

                //kategori
                String[] kategori =  buku.getKategori();
                if (!kategori.equals("N/A")) {
                    for (int i = 0; i < kategori.length; i++) {
                        query = "INSERT INTO kategori (id_buku, kategori) VALUES (?, ?)";
                        ps = conn.prepareStatement(query);
                        ps.setString(1, buku.getIdBuku());
                        ps.setString(2, kategori[i]);
                        ps.executeUpdate();
                    }
                }
            }
            conn.close();
        } catch (Exception e){
            System.out.println(e);
        }
        response.setBuku(books.toArray(new Buku[books.size()]));

        return response;
    }

    @Override
    public SOAPResponse getBookByID(String id, String author) {
        GoogleBookClient gBook = new GoogleBookClient();
        ArrayList<Buku> buku = gBook.searchBookByID(id + ';' + author);
        SOAPResponse response = new SOAPResponse();
        response.setBuku(buku.toArray(new Buku[buku.size()]));
        return response;
    }

    @Override
    public SOAPResponse getRekomendasi(String[] Category) {
        MySQLCon mysql = new MySQLCon();
        SOAPResponse resp = new SOAPResponse();
        ArrayList<Buku> books = new ArrayList<>();
        String query;

        try {
            Connection conn = mysql.connectDB();

            query = "SELECT DISTINCT id_buku FROM riwayat NATURAL JOIN kategori WHERE";
            for (int i = 0; i < Category.length; i++) {
                if (i < Category.length - 1)    // Belum Berakhir
                    query += " kategori = ? OR";
                else    // Terakhir
                    query += " kategori = ?";
            }
            query += " ORDER BY jumlah ASC";

            System.out.println(query);
            PreparedStatement ps = conn.prepareStatement(query);
            for (int i = 0; i < Category.length; i++) {
                // Mengisi bagian "?" pada Query berdasarkan larik Category
                ps.setString(i + 1, Category[i]);
            }
            ResultSet rs = ps.executeQuery();

            GoogleBookClient gBook = new GoogleBookClient();
            ArrayList<Buku> tempBuku = new ArrayList<>();

            if (rs.next()) {
                // Tidak kosong
                ArrayList<Buku> result = new ArrayList<>();

                do {
                    System.out.println(rs.getString(1));
                    //bikin buku baru

                    result = gBook.searchBookByID(rs.getString(1));
                    tempBuku.add(result.get(0));
                } while (rs.next());

            } else {
                // Kosong
                Random randomGenerator = new Random();
                int idx = randomGenerator.nextInt(Category.length);
                conn.close();
                tempBuku = gBook.searchBookByCategory(Category[idx]);
            }

            if (tempBuku.size() >= 4) {
                for (int i = 0; i < 4; i++) {
                    books.add(tempBuku.get(i));
                }
            } else {
                books = tempBuku;
            }

            conn.close();
        } catch (Exception e) {
            System.out.println(e);
        }

        resp.setBuku(books.toArray(new Buku[books.size()]));
        return resp;
        /* MySQLCon mysql = new MySQLCon();
        String q1, bestKategori;
        try{
            Connection conn = mysql.connectDB();
            q1 = "SELECT kategori, SUM(jumlah) AS total_kategori " +
                    "FROM (SELECT id_buku, jumlah FROM riwayat WHERE no_rekening=?) AS X NATURAL JOIN kategori " +
                    "GROUP BY kategori ORDER BY total_kategori DESC";

            PreparedStatement ps = conn.prepareStatement(q1);
            ps.setString(1, no_rek);
            ResultSet rs = ps.executeQuery();

            if (rs.next()) {
                bestKategori = rs.getString(1);
            } else {
                ArrayList<String> allKategori = new ArrayList<String>();
                Random randomGenerator = new Random();
                String q2 = "SELECT kategori FROM kategori";

                PreparedStatement PS = conn.prepareStatement(q2);
                ResultSet Hasil = PS.executeQuery();

                while (Hasil.next()) {
                    allKategori.add(Hasil.getString(1));
                }

                int idx = randomGenerator.nextInt(allKategori.size());
                bestKategori = allKategori.get(idx);
            }

            conn.close();

            GoogleBookClient gBook = new GoogleBookClient();
            books = gBook.searchBookByCategory(bestKategori);
        } catch (Exception e){
            System.out.println(e);
        }
        resp.setBuku(books.toArray(new Buku[books.size()]));
        return resp; */
    }
}