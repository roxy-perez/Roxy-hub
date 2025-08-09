from flask import Flask, jsonify, request, send_from_directory, abort
import os

app = Flask(__name__)
BASE = "/mnt/nas"
API_TOKEN = os.environ.get("API_TOKEN", "CAMBIAR_TOKEN")

def check_auth():
    token = request.headers.get('Authorization')
    if not token or token != f"Bearer {API_TOKEN}":
        abort(401)

@app.route('/list', methods=['GET'])
def list_dir():
    check_auth()
    path = request.args.get('path','/')
    full = os.path.realpath(os.path.join(BASE, path.lstrip('/')))
    if not full.startswith(BASE):
        return jsonify({"error":"invalid path"}),400
    items = []
    try:
        for name in os.listdir(full):
            p = os.path.join(full, name)
            items.append({
                "name": name,
                "is_dir": os.path.isdir(p),
                "size": os.path.getsize(p) if os.path.isfile(p) else None
            })
    except FileNotFoundError:
        return jsonify({"error":"path not found"}),404
    return jsonify({"path": path, "items": items})

@app.route('/download', methods=['GET'])
def download():
    check_auth()
    path = request.args.get('path')
    full = os.path.realpath(os.path.join(BASE, path.lstrip('/')))
    dirpath = os.path.dirname(full)
    filename = os.path.basename(full)
    return send_from_directory(dirpath, filename, as_attachment=True)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
