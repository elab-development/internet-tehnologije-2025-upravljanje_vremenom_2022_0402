import { useEffect, useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Zadatak.css";

function Zadatak() {
  const [zadaci, setZadaci] = useState([]);
  const [naslov, setNaslov] = useState("");
  const [opis, setOpis] = useState("");
  const [uradjeno, setUradjeno] = useState(false);

  useEffect(() => {
    // Primer inicijalnih zadataka
    setZadaci([
      { naslov: "Prvi zadatak", uradjeno: false },
      { naslov: "Drugi zadatak", uradjeno: true },
    ]);
  }, []);

  const dodajZadatak = () => {
    if (!naslov) return;
    setZadaci([...zadaci, { naslov, opis, uradjeno }]);
    setNaslov("");
    setOpis("");
    setUradjeno(false);
  };

  const toggleUradjeno = (index) => {
    const novaLista = [...zadaci];
    novaLista[index].uradjeno = !novaLista[index].uradjeno;
    setZadaci(novaLista);
  };

  return (
    <div className="zadatak-container">
      <h2>Moji zadaci</h2>

      <div className="zadatak-input">
        <Input value={naslov} onChange={(e) => setNaslov(e.target.value)} placeholder="Naslov zadatka" />
        <Input value={opis} onChange={(e) => setOpis(e.target.value)} placeholder="Opis zadatka" />
        <label>
          <input type="checkbox" checked={uradjeno} onChange={() => setUradjeno(!uradjeno)} /> Urađeno
        </label>
        <Button text="Dodaj zadatak" onClick={dodajZadatak} type="primary" />
      </div>

      <div className="zadatak-list">
        {zadaci.length === 0 ? (
          <p>Nema zadataka.</p>
        ) : (
          zadaci.map((z, index) => (
            <Card
              key={index}
              title={z.naslov}
              content={z.opis}
              footer={
                <Button
                  text={z.uradjeno ? "Završeno" : "Označi kao urađeno"}
                  onClick={() => toggleUradjeno(index)}
                  type="success"
                />
              }
            />
          ))
        )}
      </div>
    </div>
  );
}

export default Zadatak;

