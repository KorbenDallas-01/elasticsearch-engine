import os
from elasticsearch import Elasticsearch, helpers

# polaczenie do elastic
es = Elasticsearch("http://localhost:9200")  # endpoint

# pliki txt - lokalizacja
directory_path = "/home/elastic/text"  

# funkcja do stworzenia indeksu na podstawie plikow txt
def create_document(file_path):
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()
        filename = os.path.basename(file_path).replace(".txt",".pdf")
        return {
            "_index": "data_science",  # index
            "_id": filename,  # nazwa pliku - musi byc unikalna bo bedzie po niej wyszukiwanie
            "_source": {
                "filename": filename,
                "content": content
            }
        }

# indeksowanie 
actions = [create_document(os.path.join(directory_path, filename))
            for filename in os.listdir(directory_path) if filename.endswith(".txt")]
helpers.bulk(es, actions)

print("Files indexed successfully!")

