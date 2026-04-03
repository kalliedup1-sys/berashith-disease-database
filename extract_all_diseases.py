import PyPDF2
import json
import re

pdf_path = r'C:\Ai PROJEKTE\Berashith_Deseaces\doc\Online_Sicknesses__Diseases_FINAL_2026.pdf'

# Extract all text from PDF
diseases = []
current_disease = None
text_buffer = []

try:
    with open(pdf_path, 'rb') as file:
        pdf_reader = PyPDF2.PdfReader(file)
        print(f"Total pages: {len(pdf_reader.pages)}")
        
        full_text = ""
        for page_num in range(len(pdf_reader.pages)):
            page = pdf_reader.pages[page_num]
            text = page.extract_text()
            full_text += f"\n--- PAGE {page_num + 1} ---\n{text}"
        
        # Save raw text for analysis
        with open('extracted_text.txt', 'w', encoding='utf-8') as f:
            f.write(full_text)
        
        print(f"✓ Extracted text from {len(pdf_reader.pages)} pages")
        print("✓ Saved to extracted_text.txt for analysis")
        
except Exception as e:
    print(f"Error: {e}")
