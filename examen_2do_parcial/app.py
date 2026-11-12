#!/usr/bin/env python3

from flask import Flask, redirect, render_template, request, flash, url_for
from flask_mysqldb import MySQL

app = Flask(__name__)

app.config["TEMPLATES_AUTO_RELOAD"]

# mysql
app.config["MYSQL_HOST"] = "localhost"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "SeMeOlvido01"
app.config["MYSQL_DB"] = "examen_p2"

app.secret_key = "mysecretkey"

mysql = MySQL(app)

@app.route("/")
def index():
    con = mysql.connection.cursor()
    con.execute("select * from productos")
    productos = con.fetchall()
    print(productos)
    return render_template("index.html", listaProductos=productos)

@app.route("/guardar", methods=['POST'])
def guardar():
    if request.method == "POST":
        nombre = request.form["nombre"]
        descripcion = request.form["descripcion"]
        precio = request.form["precio"]
        stock = request.form["stock"]
        print(nombre, descripcion, precio, stock)

        con = mysql.connection.cursor()
        con.execute("insert into productos (nombre, descripcion, precio, stock) values (%s, %s, %s, %s)", (nombre, descripcion, precio, stock))
        mysql.connection.commit()
    flash("el producto fue registrado exitosamente.")
    return redirect(url_for("index"))

@app.route("/editar/<int:id>")
def editar(id):
    con = mysql.connection.cursor()
    con.execute("select * from productos where id_producto=%s", (id,))
    consultarId = con.fetchone()
    con.close()
    return render_template("editarProducto.html", producto=consultarId)

@app.route("/actualizar/<int:id>", methods=["POST"])
def actualizar(id):
    if request.method == "POST":
        nombre = request.form["nombre"]
        descripcion = request.form["descripcion"]
        precio = request.form["precio"]
        stock = request.form["stock"]
        print(nombre, descripcion, precio, stock)

        con = mysql.connection.cursor()
        con.execute("update productos set nombre=%s, descripcion=%s, precio=%s, stock=%s where id_producto=%s", (nombre, descripcion, precio, stock, id))
        mysql.connection.commit()
    flash(f"Se actualizó el producto con id {id}.")
    return redirect(url_for("index"))

@app.route("/eliminar/<int:id>", methods=["POST"])
def eliminar(id):
    if request.method == "POST":
        nombre = request.form["nombre"]
        con = mysql.connection.cursor()
        con.execute("delete from productos where id_producto=%s", (id,))
        flash(f"se eliminó el producto '{nombre}'.")
    return redirect(url_for("index"))

if __name__ == '__main__':
    app.run(debug=True)
