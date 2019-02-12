package com.googlebooks.api;

import org.json.JSONArray;
import org.json.JSONObject;
import java.util.ArrayList;

public class GoogleBookClient {
    private GoogleBookURLConnection conn;

    public GoogleBookClient() {
        this.conn = new GoogleBookURLConnection();
    }

    /**
     * Book search methods
     */

    public ArrayList<Buku> searchBookByTitle(String query) {
        return searchBook(query, "title");
    }

    public ArrayList<Buku> searchBookByCategory(String query) {
        return searchBook(query, "categories");
    }

    public ArrayList<Buku> searchBookByID(String query) {
        return searchBook(query, "id");
    }

    private ArrayList<Buku> searchBook(String query, String type) {
        ArrayList<Buku> booksResult = new ArrayList<>();
        JSONObject resultJSON = this.conn.makeRequest(query, type);

        if (isRequestSuccess(resultJSON)) {
            booksResult = parseSearchResults(resultJSON);
        }
        return booksResult;
    }

    /**
     * Check if API request success
     */
    private Boolean isRequestSuccess(JSONObject result) {
        return !result.has("error");
    }

    /**
     * PARSE JSONObject -> Array of Buku
     */
    private ArrayList<Buku> parseSearchResults(JSONObject result) {
        ArrayList<Buku> booksResult = new ArrayList<>();
        if (result.has("items")) {
            JSONArray booksJSON = result.getJSONArray("items");
            for (int i = 0; i < booksJSON.length(); i++) {
                Buku buku;
                buku = parseBuku((JSONObject) booksJSON.get(i));
                booksResult.add(buku);
            }
        }
        return booksResult;
    }

    private Buku parseBuku(JSONObject bookJSON) {
        String id_buku = bookJSON.getString("id");
        String pengarang;
        boolean isForSale;
        int harga;
        double rating;
        String mataUang = "";
        String deskripsi;
        String gambar;
        String[] kategori;

        //Detail
        JSONObject volumeInfo = bookJSON.getJSONObject("volumeInfo");
        String judul = volumeInfo.getString("title");
        if (volumeInfo.has("authors")) {
            pengarang = volumeInfo.getJSONArray("authors").getString(0);
        } else {
            pengarang = "N/A";
        }
        if (volumeInfo.has("description")) {
            deskripsi = volumeInfo.getString("description");
        } else {
            deskripsi = "N/A";
        }
        if (volumeInfo.has("averageRating")) {
            rating = volumeInfo.getDouble("averageRating");
        } else {
            rating = 0.0;
        }

        //Foto
        if (volumeInfo.has("imageLinks")) {
            JSONObject imageInfo = volumeInfo.getJSONObject("imageLinks");
            if (imageInfo.has("thumbnail")) {
                gambar = imageInfo.getString("thumbnail");
            } else {
                gambar = "N/A";
            }
        } else {
            gambar = "N/A";
        }

        //Harga
        JSONObject saleInfo = bookJSON.getJSONObject("saleInfo");
        isForSale = (saleInfo.getString("saleability")).equals("FOR_SALE");
        if (isForSale) {
            harga = saleInfo.getJSONObject("listPrice").getInt("amount");
            mataUang = saleInfo.getJSONObject("listPrice").getString("currencyCode");
        } else {
            harga = 0;
        }

        //Kategori
        if (volumeInfo.has("categories")) {
            JSONArray kategoriJSON = volumeInfo.getJSONArray("categories");
            kategori = new String[kategoriJSON.length()+1];
            if (kategoriJSON.length() > 0) {
                for (int i = 0; i < kategoriJSON.length(); i++) {
                    kategori[i] = kategoriJSON.getString(i);
                }
            } else {
                kategori = new String[1];
                kategori[0] = "N/A";
            }
        } else {
            kategori = new String[1];
            kategori[0] = "N/A";
        }
        return new Buku(id_buku, isForSale, judul, pengarang, deskripsi, kategori, harga, mataUang, gambar, rating);
    }
}
