import PyPDF2
import sys

pdf_path = r"d:\laragon\www\RKPDesa\doc gueh\[REV]Proposal Skripsi_Fitria Ramadhani Prihandiva.pdf"

try:
    with open(pdf_path, 'rb') as file:
        reader = PyPDF2.PdfReader(file)
        
        # Try to read pages 32 to 36 (to make sure we catch page 34 based on numbering)
        for i in range(31, 36):
            try:
                page = reader.pages[i]
                text = page.extract_text()
                print(f"--- PAGE {i+1} ---")
                print(text)
                print("-" * 40)
            except Exception as e:
                print(f"Error reading page {i+1}: {e}")
except Exception as e:
    print(f"Error opening file: {e}")
