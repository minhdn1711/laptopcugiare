import re
import json
from slugify import slugify

class DataTransformer:
    """
    Standardizes raw crawled data for WooCommerce/Laravel production.
    """
    def __init__(self):
        self.brands = ["Dell", "HP", "Asus", "Acer", "Lenovo", "Apple", "MSI", "Gigabyte"]

    def transform(self, raw):
        title = raw['title']
        specs = raw['specs_raw']
        
        # 1. Price cleanup
        price = int(re.sub(r'\D', '', raw['price_raw'])) if raw['price_raw'] else 0
        
        # 2. Taxonomy Detection
        brand = self.detect_brand(title)
        root_cat = "Apple" if brand == "Apple" else "Laptop"
        series = self.detect_series(title)
        
        # 3. Spec Normalization
        cpu_raw = specs.get('CPU', '')
        cpu_clean = self.normalize_cpu(cpu_raw)

        return {
            "sku": f"L88-{slugify(title)[:8].upper()}",
            "title": title,
            "slug": slugify(title),
            "price": price,
            "taxonomies": {
                "product_cat": root_cat,
                "product_brand": brand,
                "product_series": series
            },
            "attributes": {
                "cpu": cpu_clean,
                "ram": specs.get('RAM', ''),
                "vga": specs.get('Card đồ họa', ''),
                "screen": specs.get('Màn hình', '')
            },
            "content": raw['content'],
            "images": raw['images']
        }

    def detect_brand(self, title):
        for b in self.brands:
            if b.lower() in title.lower(): return b
        return "Khác"

    def detect_series(self, title):
        # Basic series detection
        series_map = {
            "XPS": "XPS", "ROG": "ROG", "Nitro": "Nitro", 
            "Legion": "Legion", "Macbook Air": "Macbook Air",
            "Macbook Pro": "Macbook Pro", "Victus": "Victus"
        }
        for key, val in series_map.items():
            if key.lower() in title.lower(): return val
        return "Phổ thông"

    def normalize_cpu(self, cpu_str):
        # "Intel Core i7-12700H" -> "Core i7-12700H"
        match = re.search(r'(Core\s+i\d|Ryzen\s+\d)\s*[-\s]*(\w+)', cpu_str, re.I)
        if match:
            return f"{match.group(1).replace(' ', '-')}-{match.group(2)}"
        return cpu_str

if __name__ == "__main__":
    transformer = DataTransformer()
    # Test data
    test_raw = {"title": "Laptop Dell XPS 13", "price_raw": "25.000.000đ", "specs_raw": {"CPU": "Intel Core i7 1250U"}, "content": "", "images": []}
    # print(json.dumps(transformer.transform(test_raw), indent=2))
