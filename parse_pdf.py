import PyPDF2
import sys

file_path = "d:/laragon/www/RKPDesa/doc gueh/rkpdesa.pdf"
out_path = "C:/Users/FITRIA RAMADHANI/.gemini/antigravity/brain/b2141576-698d-476f-b3b4-b860718a5b40/pdf_preview.md"

try:
    with open(file_path, "rb") as file:
        reader = PyPDF2.PdfReader(file)
        
        with open(out_path, "w", encoding="utf-8") as out_file:
            out_file.write("# Preview of rkpdesa.pdf\n\n")
            out_file.write(f"**Total Pages:** {len(reader.pages)}\n\n")
            
            for page_num in range(len(reader.pages)):
                page = reader.pages[page_num]
                out_file.write(f"## Page {page_num + 1}\n\n")
                out_file.write("```text\n")
                out_file.write(page.extract_text())
                out_file.write("\n```\n\n")
                
    print("Success: Preview written to pdf_preview.md")
except Exception as e:
    print(f"Error reading PDF: {e}")
