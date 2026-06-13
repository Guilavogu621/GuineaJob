import requests
import re

session = requests.Session()

# 1. Obtenir la page et le token CSRF
response = session.get('http://127.0.0.1:8000/register')
token_match = re.search(r'name="_token" value="([^"]+)"', response.text)
csrf_token = token_match.group(1)

# 2. Préparer les données (avec une erreur: password mismatch)
data = {
    '_token': csrf_token,
    'nom': 'Test',
    'prenom': 'Test',
    'email': 'test.validation@test.gn',
    'role': 'candidat',
    'password': 'Password123!',
    'password_confirmation': 'Mismatch!'
}

# 3. Soumettre le formulaire
post_response = session.post('http://127.0.0.1:8000/register', data=data)

# post_response will follow the redirect automatically and GET /register
print(f"Status Code after redirect: {post_response.status_code}")
if "text-[#791F1F]" in post_response.text:
    print("Found error text styling!")
else:
    print("NO ERROR MESSAGES FOUND IN HTML!")

