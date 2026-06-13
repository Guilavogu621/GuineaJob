import requests
import re

session = requests.Session()

# 1. Obtenir la page et le token CSRF
response = session.get('http://127.0.0.1:8000/register')
token_match = re.search(r'name="_token" value="([^"]+)"', response.text)
if not token_match:
    print("No CSRF token found!")
    exit(1)

csrf_token = token_match.group(1)

# 2. Préparer les données
data = {
    '_token': csrf_token,
    'nom': 'Sow',
    'prenom': 'Amadou',
    'email': 'amadou.sow@test.gn',
    'role': 'candidat',
    'password': 'Password123!',
    'password_confirmation': 'Password123!'
}

# 3. Soumettre le formulaire
post_response = session.post('http://127.0.0.1:8000/register', data=data, allow_redirects=False)

print(f"Status Code: {post_response.status_code}")
if post_response.status_code == 302:
    print(f"Redirected to: {post_response.headers.get('Location')}")
else:
    print(post_response.text[:500])

