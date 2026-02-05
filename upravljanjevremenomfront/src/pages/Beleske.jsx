import { useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Beleske.css";

function Beleske() {
  const [beleske, setBeleske] = useState([]);
  const [naslov, setNaslov] = useState("");
  const [sadrzaj, setSadrzaj] = useState("");

  const dodajBelesku = () => {
    if (!naslov) return;
    setBeleske([...beleske, { naslov, sadrzaj }]);
    setNaslov("");
    setSadrzaj("");
  };

  return (
    <div className="beleske-container">
      <h2>Moje beleške</h2>

      <div className="beleske-input">
        <Input value={naslov} onChange={(e) => setNaslov(e.target.value)} placeholder="Naslov beleške" />
        <Input value={sadrzaj} onChange={(e) => setSadrzaj(e.target.value)} placeholder="Sadržaj beleške" />
        <Button text="Dodaj" onClick={dodajBelesku} type="primary" />
      </div>

      <div className="beleske-list">
        {beleske.length === 0 ? (
          <p>Nema beleški.</p>
        ) : (
          beleske.map((b, index) => (
            <Card key={index} title={b.naslov} content={b.sadrzaj} />
          ))
        )}
      </div>
    </div>
  );
}

export default Beleske;
