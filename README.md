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

    # Example: Get all Bitonga words
    bitonga_words = bitonga_sdk.get_bitonga_words()
    print(bitonga_words)

    # Example: Get a specific Bitonga word by ID
    word_id = 1
    bitonga_word = bitonga_sdk.get_bitonga_word(word_id)
    print(bitonga_word)

    # Example: Add a new Bitonga word
    new_word_data = {"word": "new_word", "translation": "new_translation"}
    new_word = bitonga_sdk.add_bitonga_word(new_word_data)
    print(new_word)

    # Example: Update a Bitonga word by ID
    word_id = 1
    updated_word_data = {"word": "updated_word", "translation": "updated_translation"}
    bitonga_sdk.update_bitonga_word(word_id, updated_word_data)

    # Example: Delete a Bitonga word by ID
    word_id = 1
    bitonga_sdk.delete_bitonga_word(word_id)
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
