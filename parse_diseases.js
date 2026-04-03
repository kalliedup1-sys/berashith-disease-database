const fs = require('fs');
const path = require('path');

const inputFile = path.join(__dirname, 'doc', 'Online_Sicknesses__Diseases_only.txt');
const outputFile = path.join(__dirname, 'app', 'diseases-complete-new.js');

try {
  const content = fs.readFileSync(inputFile, 'utf-8');
  const lines = content.split('\n');
  
  const diseases = [];
  let currentDisease = null;
  let currentSection = null;
  let diseaseId = 1;
  
  for (let i = 0; i < lines.length; i++) {
    const line = lines[i];
    const trimmed = line.trim();
    
    // Skip completely empty lines only at the start
    if (!trimmed && !currentDisease) continue;
    
    // New disease entry
    if (trimmed === 'NAME') {
      // Save previous disease
      if (currentDisease && currentDisease.name) {
        // Clean up the content fields
        currentDisease.description = currentDisease.description.trim();
        currentDisease.general = currentDisease.general.trim();
        currentDisease.roots = currentDisease.roots.trim();
        currentDisease.recommendations = currentDisease.recommendations.trim();
        diseases.push(currentDisease);
      }
      
      // Start new disease
      currentDisease = {
        id: diseaseId++,
        name: '',
        description: '',
        general: '',
        roots: '',
        recommendations: ''
      };
      currentSection = 'NAME';
      
      // Get name on next line
      if (i + 1 < lines.length) {
        i++;
        currentDisease.name = lines[i].trim();
      }
    } else if (trimmed === 'DESCRIPTION') {
      currentSection = 'DESCRIPTION';
    } else if (trimmed === 'GENERAL') {
      currentSection = 'GENERAL';
    } else if (trimmed === 'ROOTS') {
      currentSection = 'ROOTS';
    } else if (trimmed === 'RECOMMENDATIONS') {
      currentSection = 'RECOMMENDATIONS';
    } else if (currentDisease && currentSection && currentSection !== 'NAME') {
      // Add content to current section - preserve original spacing for bullet points
      let content = trimmed.replace(/^\*\s*/, '').trim();
      if (content && !['DESCRIPTION', 'GENERAL', 'ROOTS', 'RECOMMENDATIONS'].includes(content)) {
        if (currentDisease[currentSection]) {
          currentDisease[currentSection] += ' ' + content;
        } else {
          currentDisease[currentSection] = content;
        }
      }
    }
  }
  
  // Add last disease
  if (currentDisease && currentDisease.name) {
    diseases.push(currentDisease);
  }
  
  console.log(`✓ Parsed ${diseases.length} diseases`);
  console.log('\nFIRST 3 DISEASES:');
  for (let i = 0; i < Math.min(3, diseases.length); i++) {
    console.log(`  ID ${diseases[i].id}: ${diseases[i].name}`);
  }
  
  console.log('\n...\n');
  console.log('LAST 3 DISEASES:');
  for (let i = Math.max(0, diseases.length - 3); i < diseases.length; i++) {
    console.log(`  ID ${diseases[i].id}: ${diseases[i].name}`);
  }
  
  // Generate JavaScript
  let jsContent = '// Complete Disease Database\n';
  jsContent += '// Auto-generated from Online_Sicknesses__Diseases_only.txt\n\n';
  jsContent += 'const DISEASES = [\n';
  
  for (const disease of diseases) {
    const name = disease.name.replace(/"/g, '\\"');
    const desc = (disease.description || '').replace(/"/g, '\\"').substring(0, 200);
    const general = (disease.general || '').replace(/"/g, '\\"').substring(0, 300);
    const roots = (disease.roots || '').replace(/"/g, '\\"').substring(0, 300);
    const recs = (disease.recommendations || '').replace(/"/g, '\\"').substring(0, 300);
    
    jsContent += `  {id: ${disease.id}, name: "${name}", description: "${desc}", general: "${general}", roots: "${roots}", recommendations: "${recs}"},\n`;
  }
  
  jsContent += '];\n\n';
  jsContent += 'if (typeof module !== "undefined" && module.exports) {\n';
  jsContent += '  module.exports = DISEASES;\n';
  jsContent += '}\n';
  
  fs.writeFileSync(outputFile, jsContent, 'utf-8');
  
  console.log(`\n✓ Generated: ${outputFile}`);
  console.log(`✓ Total entries: ${diseases.length}`);
  
} catch (error) {
  console.error('ERROR:', error.message);
  process.exit(1);
}
