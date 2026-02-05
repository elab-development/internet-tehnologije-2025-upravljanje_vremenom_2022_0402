import { useState } from "react";
import { Button, Input, Card } from "../components";
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
              footer={`Poslato: ${o.poslatoU} | Kanal: ${o.kanal}`}
            />
          ))
        )}
      </div>
    </div>
  );
}

export default Obavestenje;

