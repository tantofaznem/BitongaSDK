
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.util.HashMap;
import java.util.Map;

public class BitongaDictionarySDK {
    private final String apiUrl;
    private final String apiKey;

    public BitongaDictionarySDK(String apiUrl, String apiKey) {
        this.apiUrl = apiUrl;
        this.apiKey = apiKey;
    }

    public String getBitongaWords() {
        String url = apiUrl + "/api/bitonga-words";
        Map<String, String> headers = new HashMap<>();
        headers.put("Authorization", "Bearer " + apiKey);

        HttpClient client = HttpClient.newHttpClient();
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(url))
                .headers(headers.entrySet().stream()
                        .map(e -> e.getKey() + ":" + e.getValue())
                        .toArray(String[]::new))
                .GET()
                .build();

        try {
            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
            if (response.statusCode() == 200) {
                return response.body();
            } else {
                System.err.println("Error: " + response.statusCode() + " - " + response.body());
                return null;
            }
        } catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
            return null;
        }
    }

    public String getBitongaWord(int wordId) {
        String url = apiUrl + "/api/bitonga-words/" + wordId;
        Map<String, String> headers = new HashMap<>();
        headers.put("Authorization", "Bearer " + apiKey);

        HttpClient client = HttpClient.newHttpClient();
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(url))
                .headers(headers.entrySet().stream()
                        .map(e -> e.getKey() + ":" + e.getValue())
                        .toArray(String[]::new))
                .GET()
                .build();

        try {
            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
            if (response.statusCode() == 200) {
                return response.body();
            } else if (response.statusCode() == 404) {
                System.out.println("Word not found");
                return null;
            } else {
                System.err.println("Error: " + response.statusCode() + " - " + response.body());
                return null;
            }
        } catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
            return null;
        }
    }

    public String addBitongaWord(String wordData) {
        String url = apiUrl + "/api/bitonga-words";
        Map<String, String> headers = new HashMap<>();
        headers.put("Authorization", "Bearer " + apiKey);
        headers.put("Content-Type", "application/json");

        HttpClient client = HttpClient.newHttpClient();
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(url))
                .headers(headers.entrySet().stream()
                        .map(e -> e.getKey() + ":" + e.getValue())
                        .toArray(String[]::new))
                .POST(HttpRequest.BodyPublishers.ofString(wordData))
                .build();

        try {
            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
            if (response.statusCode() == 201) {
                return response.body();
            } else {
                System.err.println("Error: " + response.statusCode() + " - " + response.body());
                return null;
            }
        } catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
            return null;
        }
    }
    
    public String updateBitongaWord(int wordId, String wordData) {
        String url = apiUrl + "/api/bitonga-words/" + wordId;
        Map<String, String> headers = new HashMap<>();
        headers.put("Authorization", "Bearer " + apiKey);
        headers.put("Content-Type", "application/json");

        HttpClient client = HttpClient.newHttpClient();
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(url))
                .headers(headers.entrySet().stream()
                        .map(e -> e.getKey() + ":" + e.getValue())
                        .toArray(String[]::new))
                .PUT(HttpRequest.BodyPublishers.ofString(wordData))
                .build();

        try {
            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
            if (response.statusCode() == 204) {
                System.out.println("Word updated successfully");
                return "Word updated successfully";
            } else if (response.statusCode() == 404) {
                System.out.println("Word not found");
                return "Word not found";
            } else {
                System.err.println("Error: " + response.statusCode() + " - " + response.body());
                return null;
            }
        } catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
            return null;
        }
    }
}
