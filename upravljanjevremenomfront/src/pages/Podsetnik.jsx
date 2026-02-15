import { useState } from "react";
import Button from "../components/Button";
import Card from "../components/Card";
import Input from "../components/Input";
import "./Podsetnik.css";

function Podsetnik() {
  const [podsetnici, setPodsetnici] = useState([]);
  const [vreme, setVreme] = useState("");
  const [aktivan, setAktivan] = useState(true);

  const dodajPodsetnik = () => {
    if (!vreme) return;
    setPodsetnici([...podsetnici, { vreme, aktivan }]);
    setVreme("");
    setAktivan(true);
  };

  const obrisiPodsetnik = (index) => {
  const novaLista = podsetnici.filter((_, i) => i !== index);
  setPodsetnici(novaLista);
  };

  const toggleAktivan = (index) => {
    const novaLista = [...podsetnici];
    novaLista[index].aktivan = !novaLista[index].aktivan;
    setPodsetnici(novaLista);
  };

  return (
    <div className="podsetnik-container">
      <h2>Podsetnici</h2>

      <div className="podsetnik-input">
        <Input type="datetime-local" value={vreme} onChange={(e) => setVreme(e.target.value)} placeholder="Vreme podsetnika" />
        <label>
          <input type="checkbox" checked={aktivan} onChange={() => setAktivan(!aktivan)} /> Aktivan
        </label>
        <Button text="Dodaj podsetnik" onClick={dodajPodsetnik} type="primary" />
      </div>

      <div className="podsetnik-list">
        {podsetnici.length === 0 ? (
          <p>Nema podsetnika.</p>
        ) : (
          podsetnici.map((p, index) => (
            <Card
              key={index}
              title={`Podsetnik #${index + 1}`}
              content={`Vreme: ${p.vreme}`}
              footer={
                <div className="podsetnik-actions">
                  <Button
                    text="Obriši"
                    onClick={() => obrisiPodsetnik(index)}
                    type="danger"
                  />
                  <Button
                    text={p.aktivan ? "Deaktiviraj" : "Aktiviraj"}
                    onClick={() => toggleAktivan(index)}
                    type={p.aktivan ? "success" : "danger"}
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

export default Podsetnik;
