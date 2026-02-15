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

  const obrisiZadatak = (index) => {
  const novaLista = zadaci.filter((_, i) => i !== index);
  setZadaci(novaLista);
  };

  const izmeniZadatak = (index) => {
  const noviNaslov = prompt("Unesite novi naslov zadatka:", zadaci[index].naziv);
  const noviOpis = prompt("Unesite novi opis zadatka:", zadaci[index].opis);

  if (!noviNaslov) return;

  const novaLista = [...zadaci];
  novaLista[index] = { naziv: noviNaslov, opis: noviOpis };
  setZadaci(novaLista);
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
                <div className="zadatak-actions">
                < Button
                  text="Izmeni"
                  onClick={() => izmeniZadatak(index)}
                  type="secondary"
                />
                <Button
                  text="Obriši"
                  onClick={() => obrisiZadatak(index)}
                  type="danger"
                />
                <Button
                  text={z.uradjeno ? "Završeno" : "Označi kao urađeno"}
                  onClick={() => toggleUradjeno(index)}
                  type="success"
                />
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

