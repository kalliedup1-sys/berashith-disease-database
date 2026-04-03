const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'doc', 'Online_Sicknesses__Diseases_only.txt');
const content = fs.readFileSync(filePath, 'utf-8');

const diseases = [];
let currentDisease = null;
let currentSection = '';

const lines = content.split('\n');

for (let i = 0; i < lines.length; i++) {
    let line = lines[i].trim();
    
    if (line === 'NAME') {
        if (currentDisease && currentDisease.name) {
            diseases.push(currentDisease);
        }
        currentDisease = {
            id: diseases.length + 1,
            name: '',
            description: '',
            general: '',
            roots: '',
            recommendations: ''
        };
        currentSection = 'name';
        i++;
        if (i < lines.length) {
            currentDisease.name = lines[i].trim();
        }
    } else if (line === 'DESCRIPTION') {
        currentSection = 'description';
    } else if (line === 'GENERAL') {
        currentSection = 'general';
    } else if (line === 'ROOTS') {
        currentSection = 'roots';
    } else if (line === 'RECOMMENDATIONS') {
        currentSection = 'recommendations';
    } else if (line.startsWith('*')) {
        line = line.replace(/^\*\s*/, '').trim();
        if (currentDisease && line) {
            if (currentSection === 'description') {
                currentDisease.description += (currentDisease.description ? ' ' : '') + line;
            } else if (currentSection === 'general') {
                currentDisease.general += (currentDisease.general ? ' ' : '') + line;
            } else if (currentSection === 'roots') {
                currentDisease.roots += (currentDisease.roots ? ' ' : '') + line;
            } else if (currentSection === 'recommendations') {
                currentDisease.recommendations += (currentDisease.recommendations ? ' ' : '') + line;
            }
        }
    }
}

if (currentDisease && currentDisease.name) {
    diseases.push(currentDisease);
}

diseases.forEach(d => {
    d.description = d.description.substring(0, 200);
    d.general = d.general.substring(0, 300);
    d.roots = d.roots.substring(0, 250);
    d.recommendations = d.recommendations.substring(0, 250);
});

const jsContent = `// Complete 359-Disease Database
// Generated from Online_Sicknesses__Diseases_only.txt

const DISEASES = [
${diseases.map(d => `  {id: ${d.id}, name: "${d.name.replace(/"/g, '\\"')}", description: "${d.description.replace(/"/g, '\\"').replace(/\n/g, ' ')}", general: "${d.general.replace(/"/g, '\\"').replace(/\n/g, ' ')}", roots: "${d.roots.replace(/"/g, '\\"').replace(/\n/g, ' ')}", recommendations: "${d.recommendations.replace(/"/g, '\\"').replace(/\n/g, ' ')}"}`).join(',\n')}
];`;

fs.writeFileSync(path.join(__dirname, 'app', 'diseases-complete-359.js'), jsContent);

console.log(`✓ Generated ${diseases.length} diseases`);
console.log(`FIRST: ID ${diseases[0].id}: ${diseases[0].name}`);
console.log(`LAST: ID ${diseases[diseases.length - 1].id}: ${diseases[diseases.length - 1].name}`);
console.log(`✓ File saved to: app/diseases-complete-359.js`);
