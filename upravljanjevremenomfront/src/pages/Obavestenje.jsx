import { useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Obavestenje.css";

function Obavestenje() {
  const currentUser = JSON.parse(localStorage.getItem("currentUser"));

  // Učitaj obaveštenja iz localStorage
  const savedObavestenja = JSON.parse(localStorage.getItem("obavestenja") || "[]");
  const [obavestenja, setObavestenja] = useState(savedObavestenja);
  const [novaPoruka, setNovaPoruka] = useState("");
  const [kanal, setKanal] = useState("email");

  // Filtriraj obaveštenja po tipu korisnika
  const obavestenjaZaKorisnika = obavestenja.filter((o) => {
    if (currentUser.role === "admin") return true;
    if (currentUser.role === "premium") return o.userEmail === currentUser.email;
    return false; // regular ne vidi ništa
  });

  const dodajObavestenje = () => {
    if (!novaPoruka) return;

    const novoObavestenje = {
      poruka: novaPoruka,
      kanal,
      poslatoU: new Date().toLocaleString(),
      userEmail: currentUser.email, // vežemo obaveštenje za korisnika
    };

    const novaLista = [...obavestenja, novoObavestenje];
    setObavestenja(novaLista);
    localStorage.setItem("obavestenja", JSON.stringify(novaLista));

    setNovaPoruka("");
    setKanal("email");
  };

  const obrisiObavestenje = (index) => {
    const novaLista = obavestenja.filter((_, i) => i !== index);
    setObavestenja(novaLista);
    localStorage.setItem("obavestenja", JSON.stringify(novaLista));
  };

  const izmeniObavestenje = (index) => {
    const noviTekst = prompt("Unesite novi tekst obaveštenja:", obavestenja[index].poruka);
    if (!noviTekst) return;

    const novaLista = [...obavestenja];
    novaLista[index].poruka = noviTekst;
    setObavestenja(novaLista);
    localStorage.setItem("obavestenja", JSON.stringify(novaLista));
  };

  return (
    <div className="obavestenje-container">
      <h2>Obaveštenja</h2>
      {currentUser.role === "regular" ? (
      <p className="no-access">Nemate pristup obaveštenjima.</p>
      ) : (

      <div className="obavestenje-input">
        <Input
          value={novaPoruka}
          onChange={(e) => setNovaPoruka(e.target.value)}
          placeholder="Unesi poruku..."
        />
        <select value={kanal} onChange={(e) => setKanal(e.target.value)}>
          <option value="email">Email</option>
          <option value="sms">SMS</option>
          <option value="push">Push</option>
        </select>
        <Button text="Dodaj obaveštenje" onClick={dodajObavestenje} type="primary" />
      </div>
      )}
      <div className="obavestenje-list">
        {obavestenjaZaKorisnika.length === 0 ? (
          <p>Nema obaveštenja.</p>
        ) : (
          obavestenjaZaKorisnika.map((o, index) => (
            <Card
              key={index}
              title={`Obaveštenje #${index + 1}`}
              content={o.poruka}
              footer={
                <div className="obavestenje-actions">
                  <span>Poslato: {o.poslatoU} | Kanal: {o.kanal}</span>
                  <div>
                    <Button text="Izmeni" onClick={() => izmeniObavestenje(index)} type="secondary" />
                    <Button text="Obriši" onClick={() => obrisiObavestenje(index)} type="danger" />
                  </div>
                </div>
              }
            />
          ))
        )}
      </div>
    </div>
  );
}

export default Obavestenje;
