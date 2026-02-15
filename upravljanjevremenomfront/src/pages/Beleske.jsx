import { useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Beleske.css";

function Beleske() {
  const currentUser = JSON.parse(localStorage.getItem("currentUser"));

  // Učitaj beleške iz localStorage
  const sacuvaneBeleske = JSON.parse(localStorage.getItem("beleske") || "[]");
  const [beleske, setBeleske] = useState(sacuvaneBeleske);

  const [naslov, setNaslov] = useState("");
  const [sadrzaj, setSadrzaj] = useState("");

  // Filtriranje beleški za prikaz
  const beleskeZaPrikaz = beleske.filter((b) => {
    if (currentUser.role === "admin") return true; // vidi sve
    return b.userEmail === currentUser.email;       // premium/regular samo svoje
  });

  // Funkcija koja proverava da li korisnik može menjati belešku
  const mozeMenjati = (beleska) => beleska.userEmail === currentUser.email;

  // Dodavanje nove beleške
  const dodajBelesku = () => {
    if (!naslov) return;

    const novaBeleska = {
      id: Date.now(), // jedinstveni ID
      naslov,
      sadrzaj,
      userEmail: currentUser.email,
      kreirana: new Date().toLocaleString(),
    };

    const novaLista = [...beleske, novaBeleska];
    setBeleske(novaLista);
    localStorage.setItem("beleske", JSON.stringify(novaLista));

    setNaslov("");
    setSadrzaj("");
  };

  // Brisanje beleške
  const obrisiBelesku = (id) => {
    const novaLista = beleske.filter((b) => b.id !== id || !mozeMenjati(b));
    setBeleske(novaLista);
    localStorage.setItem("beleske", JSON.stringify(novaLista));
  };

  // Izmena beleške
  const izmeniBelesku = (id) => {
    const beleska = beleske.find((b) => b.id === id);
    if (!mozeMenjati(beleska)) return; // admin ne može tuđe

    const noviNaslov = prompt("Unesite novi naslov:", beleska.naslov);
    const noviSadrzaj = prompt("Unesite novi sadržaj:", beleska.sadrzaj);
    if (!noviNaslov) return;

    const novaLista = beleske.map((b) =>
      b.id === id && mozeMenjati(b)
        ? { ...b, naslov: noviNaslov, sadrzaj: noviSadrzaj }
        : b
    );

    setBeleske(novaLista);
    localStorage.setItem("beleske", JSON.stringify(novaLista));
  };

  return (
    <div className="beleske-container">
      <h2>
        {currentUser.role === "admin" ? "Pregled svih beleški" : "Moje beleške"}
      </h2>

      <div className="beleske-input">
        <Input
          value={naslov}
          onChange={(e) => setNaslov(e.target.value)}
          placeholder="Naslov beleške"
        />
        <Input
          value={sadrzaj}
          onChange={(e) => setSadrzaj(e.target.value)}
          placeholder="Sadržaj beleške"
        />
        <Button text="Dodaj" onClick={dodajBelesku} type="primary" />
      </div>

      <div className="beleske-list">
        {beleskeZaPrikaz.length === 0 ? (
          <p>Nema beleški.</p>
        ) : (
          beleskeZaPrikaz.map((b) => (
            <Card
              key={b.id}
              title={b.naslov}
              content={
                <>
                  <p>{b.sadrzaj}</p>
                  <small>Vlasnik: {b.userEmail}</small>
                </>
              }
              footer={
                <div className="beleska-actions">
                  {mozeMenjati(b) && (
                    <>
                      <Button
                        text="Izmeni"
                        onClick={() => izmeniBelesku(b.id)}
                        type="secondary"
                      />
                      <Button
                        text="Obriši"
                        onClick={() => obrisiBelesku(b.id)}
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

export default Beleske;
