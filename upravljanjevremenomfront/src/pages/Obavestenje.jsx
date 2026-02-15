import { useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Obavestenje.css";

function Obavestenje() {
  const [obavestenja, setObavestenja] = useState([]);
  const [novaPoruka, setNovaPoruka] = useState("");
  const [kanal, setKanal] = useState("email");

  const dodajObavestenje = () => {
    if (!novaPoruka) return;
    const poslatoU = new Date().toLocaleString();
    setObavestenja([...obavestenja, { poruka: novaPoruka, poslatoU, kanal }]);
    setNovaPoruka("");
    setKanal("email");
  };

  const obrisiObavestenje = (index) => {
    const novaLista = obavestenja.filter((_, i) => i !== index);
    setObavestenja(novaLista);
  };

  const izmeniObavestenje = (index) => {
    const noviTekst = prompt("Unesite novi tekst obaveštenja:", obavestenja[index].poruka);
    if (!noviTekst) return;

    const novaLista = [...obavestenja];
    novaLista[index].poruka = noviTekst;
    setObavestenja(novaLista);
};
  return (
    <div className="obavestenje-container">
      <h2>Obaveštenja</h2>

      <div className="obavestenje-input">
        <Input value={novaPoruka} onChange={(e) => setNovaPoruka(e.target.value)} placeholder="Unesi poruku..." />
        <select value={kanal} onChange={(e) => setKanal(e.target.value)}>
          <option value="email">Email</option>
          <option value="sms">SMS</option>
          <option value="push">Push</option>
        </select>
        <Button text="Dodaj obaveštenje" onClick={dodajObavestenje} type="primary" />
      </div>

      <div className="obavestenje-list">
        {obavestenja.length === 0 ? (
          <p>Nema obaveštenja.</p>
        ) : (
          obavestenja.map((o, index) => (
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

