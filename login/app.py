#!/usr/bin/env python3

from flask import Flask, redirect, render_template, request, session, url_for
from flask_mysqldb import MySQL
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)

app.config["TEMPLATES_AUTO_RELOAD"] = True
app.config["MYSQL_HOST"] = "localhost"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "SeMeOlvido01"
app.config["MYSQL_DB"] = "dbflask"
app.secret_key = "mysecretkey"

mysql = MySQL(app)

@app.route("/")
def home():
    return render_template("login.html")

@app.route("/registro", methods=["GET", "POST"])
def registro():
    if request.method == "POST":
        nombre = request.form["nombre"]
        apellido_p = request.form["apellido_p"]
        apellido_m = request.form["apellido_m"]
        correo = request.form["correo"]
        contraseña = request.form["contraseña"]
        id_rol = request.form["id_rol"]
        password_hash = generate_password_hash(contraseña) # generamos un hash a partir de la contraseña proporcionada por el usuario
        cursor = mysql.connection.cursor()
        sql = "select id_usuario from usuarios where correo = %s"
        cursor.execute(sql, (correo,))
        if cursor.fetchone():
            cursor.close()
            return redirect(url_for("login")) # si el usuario existe, ir al login
        sql = "insert into usuarios (nombre, apellido_p, apellido_m, correo, password_hash, id_rol) values (%s, %s, %s, %s, %s, %s)"
        cursor.execute(sql, (nombre, apellido_p, apellido_m, correo, password_hash, id_rol,))
        mysql.connection.commit()
        cursor.close()
        return redirect(url_for("home"))
    return render_template("registro.html")

@app.route("/login", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        correo = request.form["correo"]
        password = request.form["password"]
        cursor = mysql.connection.cursor()
        sql = "select u.id_usuario, u.nombre, u.apellido_p, u.apellido_m, u.correo, u.password_hash, r.nombre from usuarios as u inner join roles as r on u.id_rol = r.id_rol where u.correo = %s"
        cursor.execute(sql, (correo,))
        usuario = cursor.fetchone()
        cursor.close()
        if usuario and check_password_hash(usuario[5], password):
            session["id_usuario"] = usuario[0]
            session["nombre"] = usuario[1]
            session["rol"] = usuario[6]
            if session["rol"] == "Administrador": # si el usuario existe y es Administrador,
                return redirect(url_for("admin")) # abrir panel de Administrador
            return redirect(url_for("usuario")) # si existe pero no es Administrador, abrir panel de usuario
        # si no existe el usuario
        return render_template("login.html", error="Correo o contraseña incorrectos.")
    return render_template("login.html")

@app.route("/usuario")
def usuario():
    return render_template("usuario.html")

@app.route("/admin")
def admin():
    return render_template("admin.html")

@app.route("/logout")
def logout():
    return redirect(url_for("home"))

if __name__ == "__main__":
    app.run(port=5000)
