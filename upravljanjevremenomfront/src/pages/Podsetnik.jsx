import { useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Podsetnik.css";

function Podsetnik() {
  const currentUser = JSON.parse(localStorage.getItem("currentUser"));

  // Učitaj podsetnike iz localStorage
  const sacuvaniPodsetnici = JSON.parse(localStorage.getItem("podsetnici") || "[]");
  const [podsetnici, setPodsetnici] = useState(sacuvaniPodsetnici);

  const [vreme, setVreme] = useState("");
  const [aktivan, setAktivan] = useState(true);

  // Filtriranje podsetnika za prikaz
  const podsetniciZaPrikaz = podsetnici.filter((p) => {
    if (currentUser.role === "admin") return true; // vidi sve
    return p.userEmail === currentUser.email;       // premium/regular samo svoje
  });

  // Funkcija koja proverava da li korisnik može menjati podsetnik
  const mozeMenjati = (p) => p.userEmail === currentUser.email;

  // Dodavanje novog podsetnika
  const dodajPodsetnik = () => {
    if (!vreme) return;

    const noviPodsetnik = {
      id: Date.now(), // jedinstveni ID
      vreme,
      aktivan,
      userEmail: currentUser.email,
      kreiran: new Date().toLocaleString(),
    };

    const novaLista = [...podsetnici, noviPodsetnik];
    setPodsetnici(novaLista);
    localStorage.setItem("podsetnici", JSON.stringify(novaLista));

    setVreme("");
    setAktivan(true);
  };

  // Brisanje podsetnika
  const obrisiPodsetnik = (id) => {
    const novaLista = podsetnici.filter((p) => p.id !== id || !mozeMenjati(p));
    setPodsetnici(novaLista);
    localStorage.setItem("podsetnici", JSON.stringify(novaLista));
  };

  // Toggle aktivan status
  const toggleAktivan = (id) => {
    const novaLista = podsetnici.map((p) =>
      p.id === id && mozeMenjati(p) ? { ...p, aktivan: !p.aktivan } : p
    );

    setPodsetnici(novaLista);
    localStorage.setItem("podsetnici", JSON.stringify(novaLista));
  };

  return (
    <div className="podsetnik-container">
      <h2>
        {currentUser.role === "admin" ? "Pregled svih podsetnika" : "Moji podsetnici"}
      </h2>

      <div className="podsetnik-input">
        <Input
          type="datetime-local"
          value={vreme}
          onChange={(e) => setVreme(e.target.value)}
          placeholder="Vreme podsetnika"
        />
        <label>
          <input
            type="checkbox"
            checked={aktivan}
            onChange={() => setAktivan(!aktivan)}
          />{" "}
          Aktivan
        </label>
        <Button text="Dodaj podsetnik" onClick={dodajPodsetnik} type="primary" />
      </div>

      <div className="podsetnik-list">
        {podsetniciZaPrikaz.length === 0 ? (
          <p>Nema podsetnika.</p>
        ) : (
          podsetniciZaPrikaz.map((p) => (
            <Card
              key={p.id}
              title={`Podsetnik`}
              content={
                <>
                  <p>Vreme: {p.vreme}</p>
                  <small>Vlasnik: {p.userEmail}</small>
                </>
              }
              footer={
                <div className="podsetnik-actions">
                  {mozeMenjati(p) && (
                    <>
                      <Button
                        text={p.aktivan ? "Deaktiviraj" : "Aktiviraj"}
                        onClick={() => toggleAktivan(p.id)}
                        type={p.aktivan ? "success" : "danger"}
                      />
                      <Button
                        text="Obriši"
                        onClick={() => obrisiPodsetnik(p.id)}
                        type="danger"
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

export default Podsetnik;
