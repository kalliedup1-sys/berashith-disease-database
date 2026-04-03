# PDF Extraction Instructions

## PDF File: Online_Sicknesses__Diseases_FINAL_2026.pdf
## Total Pages: 248+ pages (pages 20 onwards)
## Last Disease: "Wrist" ending on page 268 with "Learn to value yourself and life."

## To Extract All Diseases:

Since Python/Node.js extraction tools aren't available, here are the options:

### Option 1: Use Online PDF Tool
1. Go to: https://www.ilovepdf.com/pdf_to_excel or similar
2. Upload: C:\Ai PROJEKTE\Berashith_Deseaces\doc\Online_Sicknesses__Diseases_FINAL_2026.pdf
3. Export as CSV or Excel
4. Save to: C:\Ai PROJEKTE\Berashith_Deseaces\diseases_data.csv

### Option 2: Manual Extraction (Faster)
1. Open the PDF in Adobe Reader
2. Use "Tools > Export PDF > Spreadsheet"
3. Save as diseases_data.xlsx

### Option 3: Use Copilot to Read PDF
- Upload PDF to this chat
- Request: "Extract all 248+ diseases with: Name, Cause, Symptoms, Description, Treatment, Page number"

## Expected Format:
Once we have the data, it should look like:
```
Name,Cause,Symptoms,Description,Treatment,Tags,Page
Acute Respiratory Infection,Viral infection,Cough fever...,Common infectious disease,Supportive care...,respiratory|viral,21
Malaria,Mosquito-borne parasite,High fever...,Serious parasitic disease,Antimalarial drugs...,parasitic|tropical,22
...
Wrist,Strain or injury,Pain swelling...,Wrist condition,Rest immobilization...,orthopedic|injury,267
```

After extraction, I'll load all data into the search app instantly!
