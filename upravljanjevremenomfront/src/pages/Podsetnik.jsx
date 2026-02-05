import { useState } from "react";
import { Button, Input, Card } from "../components";
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
                <Button
                  text={p.aktivan ? "Deaktiviraj" : "Aktiviraj"}
                  onClick={() => toggleAktivan(index)}
                  type={p.aktivan ? "success" : "danger"}
                />
              }
            />
          ))
        )}
      </div>
    </div>
  );
}

export default Podsetnik;
