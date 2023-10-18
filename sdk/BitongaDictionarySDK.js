class BitongaDictionarySDK {
  constructor(apiUrl, apiKey) {
    this.apiUrl = apiUrl;
    this.apiKey = apiKey;
  }

  async getBitongaWords() {
    const url = `${this.apiUrl}/api/bitonga-words`;
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${this.apiKey}`,
      },
    });

    if (response.ok) {
      return response.json();
    } else {
      console.error(`Error: ${response.status} - ${await response.text()}`);
      return null;
    }
  }

  async getBitongaWord(wordId) {
    const url = `${this.apiUrl}/api/bitonga-words/${wordId}`;
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${this.apiKey}`,
      },
    });

    if (response.ok) {
      return response.json();
    } else if (response.status === 404) {
      console.error('Word not found');
      return null;
    } else {
      console.error(`Error: ${response.status} - ${await response.text()}`);
      return null;
    }
  }

  async addBitongaWord(wordData) {
    const url = `${this.apiUrl}/api/bitonga-words`;
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${this.apiKey}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(wordData),
    });

    if (response.ok) {
      return response.json();
    } else {
      console.error(`Error: ${response.status} - ${await response.text()}`);
      return null;
    }
  }

  async updateBitongaWord(wordId, wordData) {
    const url = `${this.apiUrl}/api/bitonga-words/${wordId}`;
    const response = await fetch(url, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${this.apiKey}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(wordData),
    });

    if (response.ok) {
      console.log('Word updated successfully');
      return 'Word updated successfully';
    } else if (response.status === 404) {
      console.error('Word not found');
      return 'Word not found';
    } else {
      console.error(`Error: ${response.status} - ${await response.text()}`);
      return null;
    }
  }
}
