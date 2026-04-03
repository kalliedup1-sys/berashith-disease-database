#!/usr/bin/env python3
"""
Extract all disease names from the PDF document
Starting from 'Abortion' and ending with 'Wrists'
"""

import PyPDF2
import re

pdf_path = r'c:\Ai PROJEKTE\Berashith_Deseaces\doc\Online_Sicknesses__Diseases_FINAL_2026.pdf'

try:
    with open(pdf_path, 'rb') as file:
        pdf_reader = PyPDF2.PdfReader(file)
        print(f"Total pages: {len(pdf_reader.pages)}\n")
        
        # Extract text from all pages
        full_text = ""
        for page_num in range(len(pdf_reader.pages)):
            page = pdf_reader.pages[page_num]
            text = page.extract_text()
            full_text += text + "\n"
        
        # Print first 2000 characters to see the structure
        print("=== FIRST 2000 CHARACTERS ===")
        print(full_text[:2000])
        print("\n=== SEARCHING FOR DISEASES ===\n")
        
        # Look for disease names (capitalized lines)
        lines = full_text.split('\n')
        diseases = []
        for line in lines:
            line = line.strip()
            if line and len(line) > 2:
                # Look for lines that look like disease names
                if line[0].isupper() and not line.isupper():
                    diseases.append(line)
        
        print(f"Found {len(diseases)} potential disease entries\n")
        print("First 30 entries:")
        for i, disease in enumerate(diseases[:30]):
            print(f"{i+1}. {disease}")
            
except FileNotFoundError:
    print(f"PDF file not found: {pdf_path}")
except Exception as e:
    print(f"Error: {e}")
    print("Ensure PyPDF2 is installed: pip install PyPDF2")
