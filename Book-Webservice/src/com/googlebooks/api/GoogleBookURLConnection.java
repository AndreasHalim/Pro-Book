package com.googlebooks.api;

import org.json.JSONObject;

import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

public class GoogleBookURLConnection {
    private final String BASE_URL = "https://www.googleapis.com/books/v1/volumes?key=";
    private final String QUERY_CODE = "&q=";
    private String apikey;
    private String url;

    public GoogleBookURLConnection() {
        getAPIkey();
    }

    private void getAPIkey() {
        File file = new File("./data/apikey.txt");
        try {
            BufferedReader br = new BufferedReader(new FileReader(file));
            apikey = br.readLine();
        } catch (Exception e) {
            System.out.println("Error reading apikey");
        }
    }

    private void setURL(String type, String query) throws Exception {
        String search = type + ':' + URLEncoder.encode(query, "UTF-8");
        search = search.replace("%3B", ";");
        this.url = BASE_URL + apikey + QUERY_CODE + search;
    }

    /**
     * Read and return response on JSONObject type
     */
    private JSONObject readResponse(HttpURLConnection connection) throws IOException {
        StringBuilder response = new StringBuilder();
        try (BufferedReader br = new BufferedReader(new InputStreamReader(
                connection.getInputStream()))) {
            String line;
            while ((line = br.readLine()) != null) {
                response.append(line);
            }
        }
        return new JSONObject(response.toString());
    }

    /**
     * Send request to googlebooks API
     * return response on JSONObject format
     */
    public JSONObject makeRequest(String query, String type) {
        JSONObject response = new JSONObject();
        try {
            setURL(type, query);
            URL urladdress = new URL(this.url);
            HttpURLConnection connection = (HttpURLConnection) urladdress.openConnection();
            connection.setRequestMethod("GET");

            int response_code = connection.getResponseCode();
            if (response_code != 200) {
                response.put("error", response_code);
            }

            response = readResponse(connection);

            connection.disconnect();
        } catch (Exception e) {
            System.out.println(e.getMessage());
            response.put("message", e.getMessage());
        }
        System.out.println(url);
        return response;
    }

    /**
     * Tester
     */
    public static void main(String[] args) {
        GoogleBookURLConnection gb = new GoogleBookURLConnection();
        System.out.println(gb.makeRequest("fiction", "categories"));
    }
}
