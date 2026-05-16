import requests
from bs4 import BeautifulSoup
import json
import time
import os

class Laptop88Crawler:
    """
    Crawler engine for Laptop88.vn
    """
    def __init__(self):
        self.base_url = "https://laptop88.vn"
        self.headers = {
            "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36"
        }

    def fetch_product(self, url):
        print(f"Crawling: {url}")
        try:
            response = requests.get(url, headers=self.headers, timeout=15)
            if response.status_code != 200: return None
            
            soup = BeautifulSoup(response.content, 'html.parser')
            
            # Extract basic info
            title = soup.select_one('.product-name h1').text.strip() if soup.select_one('.product-name h1') else ""
            price = soup.select_one('.product-price .price-new').text.strip() if soup.select_one('.product-price .price-new') else "0"
            
            # Extract specs
            specs = {}
            for row in soup.select('.product-spec-table tr'):
                cols = row.find_all('td')
                if len(cols) == 2:
                    specs[cols[0].text.strip()] = cols[1].text.strip()
            
            # Extract content
            content = str(soup.select_one('.product-desc-content')) if soup.select_one('.product-desc-content') else ""
            
            # Extract images
            images = [img['src'] for img in soup.select('.product-image-feature img')]
            
            return {
                "title": title,
                "price_raw": price,
                "specs_raw": specs,
                "content": content,
                "images": images,
                "url": url
            }
        except Exception as e:
            print(f"Error: {e}")
            return None

if __name__ == "__main__":
    crawler = Laptop88Crawler()
    # Test with one URL
    # data = crawler.fetch_product("https://laptop88.vn/laptop-gaming-acer-nitro-v-anv15-51-57nd.html")
    # print(json.dumps(data, indent=2, ensure_ascii=False))
