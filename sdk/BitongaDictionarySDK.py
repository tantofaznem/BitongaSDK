import requests
import json

class BitongaDictionarySDK:
    def __init__(self, api_url, api_key):
        self.api_url = api_url
        self.api_key = api_key

    def get_bitonga_words(self):
        url = f"{self.api_url}/api/bitonga-words"
        headers = {"Authorization": f"Bearer {self.api_key}"}
        response = requests.get(url, headers=headers)

        if response.status_code == 200:
            return response.json()
        else:
            print(f"Error: {response.status_code} - {response.text}")
            return None

    def get_bitonga_word(self, word_id):
        url = f"{self.api_url}/api/bitonga-words/{word_id}"
        headers = {"Authorization": f"Bearer {self.api_key}"}
        response = requests.get(url, headers=headers)

        if response.status_code == 200:
            return response.json()
        elif response.status_code == 404:
            print("Word not found")
            return None
        else:
            print(f"Error: {response.status_code} - {response.text}")
            return None

    def add_bitonga_word(self, word_data):
        url = f"{self.api_url}/api/bitonga-words"
        headers = {
            "Authorization": f"Bearer {self.api_key}",
            "Content-Type": "application/json"
        }
        response = requests.post(url, headers=headers, data=json.dumps(word_data))

        if response.status_code == 201:
            return response.json()
        else:
            print(f"Error: {response.status_code} - {response.text}")
            return None

    def update_bitonga_word(self, word_id, word_data):
        url = f"{self.api_url}/api/bitonga-words/{word_id}"
        headers = {
            "Authorization": f"Bearer {self.api_key}",
            "Content-Type": "application/json"
        }
        response = requests.put(url, headers=headers, data=json.dumps(word_data))

        if response.status_code == 204:
            print("Word updated successfully")
            return True
        elif response.status_code == 404:
            print("Word not found")
            return False
        else:
            print(f"Error: {response.status_code} - {response.text}")
            return False

    def delete_bitonga_word(self, word_id):
        url = f"{self.api_url}/api/bitonga-words/{word_id}"
        headers = {"Authorization": f"Bearer {self.api_key}"}
        response = requests.delete(url, headers=headers)

        if response.status_code == 204:
            print("Word deleted successfully")
            return True
        elif response.status_code == 404:
            print("Word not found")
            return False
        else:
            print(f"Error: {response.status_code} - {response.text}")
            return False
