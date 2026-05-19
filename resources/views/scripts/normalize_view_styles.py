from pathlib import Path
import re

base = Path(r'c:\wamp64\www\Lina_StockFlow\Stock_Flow\resources\views')
sections = ['roles', 'usuarios', 'prestamos', 'articulos', 'categorias']
files = []
for section in sections:
    for path in (base / section).glob('*.blade.php'):
        files.append(path)

replacements = [
    (r'font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight', 'font-bold text-xl text-white leading-tight'),
    (r'max-w-7xl mx-auto sm:px-6 lg:px-8"', 'max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"'),
    (r'bg-gray-800 dark:bg-gray-900 rounded-xl shadow-sm p-6 border border-gray-700', 'bg-gray-800 rounded-lg shadow-xl p-6 border border-gray-700'),
    (r'bg-gray-800 dark:bg-gray-900 rounded-xl shadow-sm overflow-hidden border border-gray-700', 'bg-gray-800 rounded-lg shadow-xl overflow-hidden border border-gray-700'),
    (r'class="text-sm text-gray-500 hover:text-gray-700"', 'class="text-sm text-gray-300 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-gray-800"'),
]

updated = []
for path in files:
    text = path.read_text(encoding='utf-8')
    original = text
    for old, new in replacements:
        text = re.sub(old, new, text)
    if text != original:
        path.write_text(text, encoding='utf-8')
        updated.append(path)

for path in updated:
    print(f'Updated {path}')
