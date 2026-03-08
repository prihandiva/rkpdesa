import pandas as pd
import sys

file_path = "d:/laragon/www/RKPDesa/doc gueh/APBDES PANDANLANDUNG 2026.xlsx"
out_path = "C:/Users/FITRIA RAMADHANI/.gemini/antigravity/brain/b2141576-698d-476f-b3b4-b860718a5b40/excel_preview.md"

try:
    xls = pd.ExcelFile(file_path)
    
    with open(out_path, "w", encoding="utf-8") as f:
        f.write("# Preview of APBDES PANDANLANDUNG 2026.xlsx\n\n")
        f.write(f"**Sheets found:** {', '.join(xls.sheet_names)}\n\n")
        
        for sheet in xls.sheet_names:
            f.write(f"## Sheet: {sheet}\n\n")
            df = pd.read_excel(xls, sheet_name=sheet)
            f.write(df.head(50).fillna('').to_markdown(index=False))
            f.write("\n\n")
            
    print("Success: Preview written to excel_preview.md")
except Exception as e:
    print(f"Error reading excel: {e}")
