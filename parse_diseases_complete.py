#!/usr/bin/env python3
"""
Parse the complete diseases text file and generate JavaScript database
"""

import re
import json

input_file = r'c:\Ai PROJEKTE\Berashith_Deseaces\doc\Online_Sicknesses__Diseases_only.txt'
output_js = r'c:\Ai PROJEKTE\Berashith_Deseaces\app\diseases-complete-new.js'

diseases = []
current_disease = {}
disease_id = 1

try:
    with open(input_file, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    
    i = 0
    while i < len(lines):
        line = lines[i].strip()
        
        # Skip empty lines
        if not line:
            i += 1
            continue
        
        # New disease starts with NAME
        if line == "NAME":
            # Save previous disease if exists
            if current_disease and 'name' in current_disease:
                diseases.append(current_disease)
            
            # Start new disease
            current_disease = {'id': disease_id}
            disease_id += 1
            i += 1
            
            # Get disease name
            if i < len(lines):
                disease_name = lines[i].strip()
                current_disease['name'] = disease_name
            i += 1
        
        # DESCRIPTION
        elif line == "DESCRIPTION":
            i += 1
            desc_lines = []
            while i < len(lines) and lines[i].strip() and not lines[i].strip().startswith(('NAME', 'GENERAL', 'ROOTS', 'RECOMMENDATIONS')):
                desc_line = lines[i].strip()
                if desc_line.startswith('*'):
                    desc_line = desc_line[1:].strip()
                if desc_line:
                    desc_lines.append(desc_line)
                i += 1
            current_disease['description'] = ' '.join(desc_lines) if desc_lines else "N/A"
        
        # GENERAL
        elif line == "GENERAL":
            i += 1
            general_lines = []
            while i < len(lines) and lines[i].strip() and not lines[i].strip().startswith(('NAME', 'DESCRIPTION', 'ROOTS', 'RECOMMENDATIONS')):
                gen_line = lines[i].strip()
                if gen_line.startswith('*'):
                    gen_line = gen_line[1:].strip()
                if gen_line:
                    general_lines.append(gen_line)
                i += 1
            current_disease['general'] = ' '.join(general_lines) if general_lines else "N/A"
        
        # ROOTS
        elif line == "ROOTS":
            i += 1
            roots_lines = []
            while i < len(lines) and lines[i].strip() and not lines[i].strip().startswith(('NAME', 'DESCRIPTION', 'GENERAL', 'RECOMMENDATIONS')):
                root_line = lines[i].strip()
                if root_line.startswith('*'):
                    root_line = root_line[1:].strip()
                if root_line:
                    roots_lines.append(root_line)
                i += 1
            current_disease['roots'] = ' '.join(roots_lines) if roots_lines else "N/A"
        
        # RECOMMENDATIONS
        elif line == "RECOMMENDATIONS":
            i += 1
            rec_lines = []
            while i < len(lines) and lines[i].strip() and not lines[i].strip().startswith(('NAME', 'DESCRIPTION', 'GENERAL', 'ROOTS')):
                rec_line = lines[i].strip()
                if rec_line.startswith('*'):
                    rec_line = rec_line[1:].strip()
                if rec_line:
                    rec_lines.append(rec_line)
                i += 1
            current_disease['recommendations'] = ' '.join(rec_lines) if rec_lines else "N/A"
        
        else:
            i += 1
    
    # Add last disease
    if current_disease and 'name' in current_disease:
        diseases.append(current_disease)
    
    print(f"✓ Parsed {len(diseases)} diseases\n")
    
    # Display first 3 and last 3 for verification
    print("FIRST 3 DISEASES:")
    for d in diseases[:3]:
        print(f"  ID {d['id']}: {d['name']}")
    
    print("\n...")
    print("\nLAST 3 DISEASES:")
    for d in diseases[-3:]:
        print(f"  ID {d['id']}: {d['name']}")
    
    # Generate JavaScript
    js_content = "// Complete Disease Database\n"
    js_content += "// Auto-generated from Online_Sicknesses__Diseases_only.txt\n\n"
    js_content += "const DISEASES = [\n"
    
    for disease in diseases:
        # Escape quotes in text fields
        name = disease.get('name', '').replace('"', '\\"')
        desc = disease.get('description', '').replace('"', '\\"')
        general = disease.get('general', '').replace('"', '\\"')
        roots = disease.get('roots', '').replace('"', '\\"')
        recs = disease.get('recommendations', '').replace('"', '\\"')
        
        js_content += f'  {{id: {disease["id"]}, name: "{name}", description: "{desc}", general: "{general}", roots: "{roots}", recommendations: "{recs}"}},\n'
    
    js_content += "];\n\n"
    js_content += "if (typeof module !== 'undefined' && module.exports) {\n"
    js_content += "  module.exports = DISEASES;\n"
    js_content += "}\n"
    
    # Write output
    with open(output_js, 'w', encoding='utf-8') as f:
        f.write(js_content)
    
    print(f"\n✓ Generated: {output_js}")
    print(f"✓ Total entries: {len(diseases)}")

except Exception as e:
    print(f"ERROR: {e}")
    import traceback
    traceback.print_exc()
