const fs = require('fs');
const path = require('path');

// 定義目錄與輸出檔案
const baseDir = path.join(process.cwd(), 'study');
const outputFile = path.join(process.cwd(), 'readme.md');

// 驗證目錄是否存在
if (!fs.existsSync(baseDir)) {
  console.error(`Error: Directory '${baseDir}' does not exist.`);
  process.exit(1);
}

// 解析 Markdown 檔案的標題
function parseMarkdownTitle(filePath) {
  try {
    const content = fs.readFileSync(filePath, 'utf-8');
    const match = content.match(/^# (.+)/);
    return match ? match[1] : 'unknown';
  } catch (error) {
    console.error(`Error reading file '${filePath}':`, error.message);
    return 'unknown';
  }
}

// 遞迴生成索引
function generateIndex(dir) {
  const indexData = {};
  const files = fs.readdirSync(dir, { withFileTypes: true });

  for (const file of files) {
    const fullPath = path.join(dir, file.name);
    if (file.isDirectory()) {
      const subIndex = generateIndex(fullPath);
      if (Object.keys(subIndex).length) {
        indexData[file.name] = subIndex;
      }
    } else if (file.isFile() && file.name.endsWith('.md')) {
      const title = parseMarkdownTitle(fullPath);
      const parentDir = path.basename(dir);
      if (!indexData[parentDir]) {
        indexData[parentDir] = [];
      }
      indexData[parentDir].push(title);
    }
  }
  return indexData;
}

// 格式化索引為 Markdown
function formatIndex(data) {
  let output = '';
  for (const [key, value] of Object.entries(data)) {
    if (Array.isArray(value)) {
      output += `## ${key}\n`;
      value.forEach((item) => {
        output += `- ${item}\n`;
      });
      output += '\n'; // 確保每個章節之後都有換行
    } else {
      output += formatIndex(value) + '\n'; // 遞迴子目錄時也加入換行
    }
  }
  return output.trim(); // 去除多餘的結尾換行
}

// 生成索引並寫入檔案
try {
  const indexData = generateIndex(baseDir);
  const formattedIndex = formatIndex(indexData);
  fs.writeFileSync(outputFile, formattedIndex, 'utf-8');
  console.log('Index generated successfully at', outputFile);
} catch (error) {
  console.error('Error generating index:', error.message);
  process.exit(1);
}
