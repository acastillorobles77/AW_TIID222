#!/usr/bin/env python3

from flask import Flask, redirect, render_template

app = Flask(__name__)

app.config["TEMPLATES_AUTO_RELOAD"] = True

# Creamos aquí unas rutas

@app.route("/")
def index():
    return "Hola desde Flask!"

@app.route("/guardar")
def guardar():
    return "Producto guardado exitosamente."

@app.route("/login")
def login():
    return render_template("login.html")

if __name__ == "__main__":
    app.run(port=5000)
