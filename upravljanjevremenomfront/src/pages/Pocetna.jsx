import { Card, Button } from "../components";
import "./Pocetna.css";
import { useNavigate } from "react-router-dom";

function Pocetna() {
  const navigate = useNavigate();

  return (
    <div className="pocetna-container">
      <h2>Dobrodošli na Task Manager</h2>

      <div className="pocetna-cards">
        <Card title="Zadaci" content="Pregledaj sve zadatke" footer={<Button text="Idi na Zadaci" onClick={() => navigate("/zadaci")} type="primary" />} />
        <Card title="Beleške" content="Pregledaj sve beleške" footer={<Button text="Idi na Beleške" onClick={() => navigate("/beleske")} type="primary" />} />
        <Card title="Podsetnici" content="Pregledaj podsetnike" footer={<Button text="Idi na Podsetnik" onClick={() => navigate("/podsetnik")} type="primary" />} />
        <Card title="Obaveštenja" content="Pregledaj obaveštenja" footer={<Button text="Idi na Obaveštenja" onClick={() => navigate("/obavestenja")} type="primary" />} />
        <Card title="Statistika" content="Pregled statistike zadataka" footer={<Button text="Idi na Statistika" onClick={() => navigate("/statistika")} type="primary" />} />
      </div>
    </div>
  );
}

export default Pocetna;


