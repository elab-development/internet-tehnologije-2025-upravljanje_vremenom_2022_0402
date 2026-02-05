import { Card } from "../components";
import "./Statistika.css";

function Statistika() {
  //primer
  const stats = {
    odradjeni: 15,
    ukupno: 20,
  };

  const procent = Math.round((stats.odradjeni / stats.ukupno) * 100);

  return (
    <div className="statistika-container">
      <h2>Statistika zadataka</h2>

      <div className="statistika-cards">
        <Card title="Odradjeni zadaci" content={stats.odradjeni} />
        <Card title="Ukupan broj zadataka" content={stats.ukupno} />
        <Card title="Procenat uspešnosti" content={`${procent}%`} />
      </div>
    </div>
  );
}

export default Statistika;

