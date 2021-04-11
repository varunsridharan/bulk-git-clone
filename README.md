# Bulk Git Clone
This is a simple **PHP** Script which can clone all your github repo into local.

## 🤔 Why ?
Well i have around 150+ repositories in personal account and 200+ in organization accounts

and i found it ⌛ consuming to clone each of them manually. 

so i created a **PHP** script which can do it for me with the help of **Github API** 

## 🚀 Usage

### Step 1
clone this into your local / download this repo 

### Step 2
Create a Personal Access Token with 👇 **Scopes**
![scopes.jpg](scopes.jpg)

### Step 3
Run **PHP** script using the 👇 CMD
```text
php cloneall.php {your-personal-github-token}
```

**With Custom Location To Save Your Repositories**
```text
php cloneall.php {your-personal-github-token} /home/your-location/path/
```

---

<!-- START common-footer.mustache  -->

<!-- END common-footer.mustache  -->
