import { useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Zadatak.css";

function Zadatak() {
  const currentUser = JSON.parse(localStorage.getItem("currentUser"));

  // Učitaj zadatke iz localStorage
  const sacuvaniZadaci = JSON.parse(localStorage.getItem("zadaci") || "[]");
  const [zadaci, setZadaci] = useState(sacuvaniZadaci);

  const [naslov, setNaslov] = useState("");
  const [opis, setOpis] = useState("");
  const [uradjeno, setUradjeno] = useState(false);

  // Filtriranje zadataka za prikaz
  const zadaciZaPrikaz = zadaci.filter((z) => {
    if (currentUser.role === "admin") return true; // vidi sve
    return z.userEmail === currentUser.email;       // premium/regular samo svoje
  });

  // Funkcija koja proverava da li korisnik može menjati zadatak
  const mozeMenjati = (zadatak) => zadatak.userEmail === currentUser.email;

  // Dodavanje novog zadatka
  const dodajZadatak = () => {
    if (!naslov) return;

    const noviZadatak = {
      id: Date.now(), // jedinstveni ID
      naslov,
      opis,
      uradjeno,
      userEmail: currentUser.email,
      kreiran: new Date().toLocaleString(),
    };

    const novaLista = [...zadaci, noviZadatak];
    setZadaci(novaLista);
    localStorage.setItem("zadaci", JSON.stringify(novaLista));

    setNaslov("");
    setOpis("");
    setUradjeno(false);
  };

  // Brisanje zadatka
  const obrisiZadatak = (id) => {
    const novaLista = zadaci.filter((z) => z.id !== id || !mozeMenjati(z));
    setZadaci(novaLista);
    localStorage.setItem("zadaci", JSON.stringify(novaLista));
  };

  // Izmena zadatka
  const izmeniZadatak = (id) => {
    const zadatak = zadaci.find((z) => z.id === id);
    if (!mozeMenjati(zadatak)) return; // admin ne može tuđe

    const noviNaslov = prompt("Unesite novi naslov zadatka:", zadatak.naslov);
    const noviOpis = prompt("Unesite novi opis zadatka:", zadatak.opis);
    if (!noviNaslov) return;

    const novaLista = zadaci.map((z) =>
      z.id === id && mozeMenjati(z)
        ? { ...z, naslov: noviNaslov, opis: noviOpis }
        : z
    );

    setZadaci(novaLista);
    localStorage.setItem("zadaci", JSON.stringify(novaLista));
  };

  // Toggle urađeno
  const toggleUradjeno = (id) => {
    const novaLista = zadaci.map((z) =>
      z.id === id && mozeMenjati(z) ? { ...z, uradjeno: !z.uradjeno } : z
    );

    setZadaci(novaLista);
    localStorage.setItem("zadaci", JSON.stringify(novaLista));
  };

  return (
    <div className="zadatak-container">
      <h2>
        {currentUser.role === "admin" ? "Pregled svih zadataka" : "Moji zadaci"}
      </h2>

      <div className="zadatak-input">
        <Input
          value={naslov}
          onChange={(e) => setNaslov(e.target.value)}
          placeholder="Naslov zadatka"
        />
        <Input
          value={opis}
          onChange={(e) => setOpis(e.target.value)}
          placeholder="Opis zadatka"
        />
        <label>
          <input
            type="checkbox"
            checked={uradjeno}
            onChange={() => setUradjeno(!uradjeno)}
          />{" "}
          Urađeno
        </label>
        <Button text="Dodaj zadatak" onClick={dodajZadatak} type="primary" />
      </div>

      <div className="zadatak-list">
        {zadaciZaPrikaz.length === 0 ? (
          <p>Nema zadataka.</p>
        ) : (
          zadaciZaPrikaz.map((z) => (
            <Card
              key={z.id}
              title={z.naslov}
              content={
                <>
                  <p>{z.opis}</p>
                  <small>Vlasnik: {z.userEmail}</small>
                </>
              }
              footer={
                <div className="zadatak-actions">
                  {mozeMenjati(z) && (
                    <>
                      <Button
                        text="Izmeni"
                        onClick={() => izmeniZadatak(z.id)}
                        type="secondary"
                      />
                      <Button
                        text="Obriši"
                        onClick={() => obrisiZadatak(z.id)}
                        type="danger"
                      />
                      <Button
                        text={z.uradjeno ? "Završeno" : "Označi kao urađeno"}
                        onClick={() => toggleUradjeno(z.id)}
                        type="success"
                      />
                    </>
                  )}
                </div>
              }
            />
          ))
        )}
      </div>
    </div>
  );
}

export default Zadatak;
