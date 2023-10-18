# Bitonga Dictionary SDK

The Bitonga Dictionary SDK allows you to access a database of Bitonga words and their translations. You can integrate this SDK into your website or app to provide Bitonga language support.

## Installation

To use the Bitonga Dictionary SDK, follow these steps:

1. Download the SDK files from the [GitHub repository](https://github.com/tantofaznem/BitongaSDK).

2. Include the `BitongaDictionarySDK.php` file in your project.

3. Initialize the SDK in your code:

```php
require_once 'path/to/BitongaDictionarySDK.php';
$bitongaSDK = new BitongaDictionarySDK();
```

## Usage

### Retrieve Bitonga Words

To retrieve a list of Bitonga words and their translations, use the `getBitongaWords()` method:

```php
$bitongaWords = $bitongaSDK->getBitongaWords();
// $bitongaWords now contains an array of Bitonga words and their translations
```

### Retrieve a Specific Word

To retrieve a specific Bitonga word by its ID, use the `getBitongaWord($id)` method (replace `{id}` with the actual word ID):

```php
$wordId = 1; // Replace with the actual word ID
$bitongaWord = $bitongaSDK->getBitongaWord($wordId);
// $bitongaWord contains the Bitonga word data for the given ID
```

### Add a New Word

To add a new Bitonga word to the dictionary, use the `addBitongaWord($data)` method:

```php
// Define the data to be added
$newWordData = array(
    'word' => 'new_word',
    'translation' => 'translation_of_new_word'
);

$newBitongaWord = $bitongaSDK->addBitongaWord($newWordData);
// $newBitongaWord now contains the newly added word's data
```


# Python Usage

```python
if __name__ == "__main__":
    api_url = "http://example.com"  # Replace with your API URL
    api_key = "your_api_key"  # Replace with your API key

    bitonga_sdk = BitongaDictionarySDK(api_url, api_key)

    # Get all Bitonga words
    bitonga_words = bitonga_sdk.get_bitonga_words()
    print(bitonga_words)

    # Get a specific Bitonga word by ID
    word_id = 1
    bitonga_word = bitonga_sdk.get_bitonga_word(word_id)
    print(bitonga_word)

    # Add a new Bitonga word
    new_word_data = {"word": "new_word", "translation": "new_translation"}
    new_word = bitonga_sdk.add_bitonga_word(new_word_data)
    print(new_word)

    # Update a Bitonga word by ID
    word_id = 1
    updated_word_data = {"word": "updated_word", "translation": "updated_translation"}
    bitonga_sdk.update_bitonga_word(word_id, updated_word_data)

```

# JavaScript Usage

```javascript
const apiUrl = 'http://example.com'; // Replace with your API URL
const apiKey = 'your_api_key'; // Replace with your API key

const bitongaSDK = new BitongaDictionarySDK(apiUrl, apiKey);

// Get all Bitonga words
bitongaSDK.getBitongaWords().then(words => {
  console.log(words);
});

// Get a specific Bitonga word by ID
const wordId = 1;
bitongaSDK.getBitongaWord(wordId).then(word => {
  console.log(word);
});

// Add a new Bitonga word
const newWordData = { word: 'new_word', translation: 'new_translation' };
bitongaSDK.addBitongaWord(newWordData).then(newWord => {
  console.log(newWord);
});

// Update a Bitonga word
const updatedWordData = { word: 'updated_word', translation: 'updated_translation' };
bitongaSDK.updateBitongaWord(1, updatedWordData).then(updateResult => {
  console.log(updateResult);
});
```

# Java Usagee:

```java
public class Main {
    public static void main(String[] args) {
        String apiUrl = "http://example.com";  // Replace with your API URL
        String apiKey = "your_api_key";        // Replace with your API key

        BitongaDictionarySDK bitongaSDK = new BitongaDictionarySDK(apiUrl, apiKey);

        // Get all Bitonga words
        String words = bitongaSDK.getBitongaWords();
        System.out.println(words);

        // Get a specific Bitonga word by ID
        int wordId = 1;
        String word = bitongaSDK.getBitongaWord(wordId);
        System.out.println(word);

        // Add a new Bitonga word
        String newWordData = "{\"word\": \"new_word\", \"translation\": \"new_translation\"}";
        String newWord = bitongaSDK.addBitongaWord(newWordData);
        System.out.println(newWord);

        // Update a Bitonga word
        String updatedWordData = "{\"word\": \"updated_word\", \"translation\": \"updated_translation\"}";
        String updateResult = bitongaSDK.updateBitongaWord(1, updatedWordData);
        System.out.println(updateResult);
    }
}
```

## Example of response

```
{
"word": "wona",
"translation": "olha"
}
```

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
