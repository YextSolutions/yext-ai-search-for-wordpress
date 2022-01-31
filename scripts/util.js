const fs = require('fs');
const path = require('path');

const getDirContents = (value) => fs.readdirSync(path.resolve(process.cwd(), value));
const getFileContents = (value) => fs.readFileSync(path.resolve(process.cwd(), value), 'utf8');
const writeDir = (value) => fs.mkdirSync(path.resolve(process.cwd(), value), { recursive: true });
const writeFile = (value, content) => fs.writeFileSync(path.resolve(process.cwd(), value), content);

module.exports = {
	getDirContents,
	getFileContents,
	writeDir,
	writeFile,
};
