import { useState, useEffect } from "react";
import Card from "../components/Card";
import "./Statistika.css";

function Statistika() {
  //const currentUser = JSON.parse(localStorage.getItem("currentUser"));
  const [stats, setStats] = useState([]);
  const [currentUser] = useState(JSON.parse(localStorage.getItem("currentUser"))
  );

  useEffect(() => {
    const sacuvaniZadaci = JSON.parse(localStorage.getItem("zadaci") || "[]");

    if (!currentUser) return;

    if (currentUser.role === "admin") {
      // Admin vidi sve zadatke, grupisano po korisniku
      const zadaciPoKorisnicima = {};

      sacuvaniZadaci.forEach((z) => {
        if (!zadaciPoKorisnicima[z.userEmail]) {
          zadaciPoKorisnicima[z.userEmail] = [];
        }
        zadaciPoKorisnicima[z.userEmail].push(z);
      });

      const statsAdmin = Object.entries(zadaciPoKorisnicima).map(
        ([email, zadaci]) => {
          const ukupno = zadaci.length;
          const odradjeni = zadaci.filter((z) => z.uradjeno).length;
          const procent = ukupno > 0 ? Math.round((odradjeni / ukupno) * 100) : 0;
          return { email, ukupno, odradjeni, procent };
        }
      );

      setStats(statsAdmin);
    } else {
      // Regular i premium vide samo svoje zadatke
      const zadaciKorisnika = sacuvaniZadaci.filter(
        (z) => z.userEmail === currentUser.email
      );
      const ukupno = zadaciKorisnika.length;
      const odradjeni = zadaciKorisnika.filter((z) => z.uradjeno).length;
      const procent = ukupno > 0 ? Math.round((odradjeni / ukupno) * 100) : 0;

      setStats([{ email: currentUser.email, ukupno, odradjeni, procent }]);
    }
  }, [currentUser]);

  return (
    <div className="statistika-container">
      <h2>Statistika zadataka</h2>

      {stats.length === 0 ? (
        <p>Nema statistike za prikaz.</p>
      ) : (
        stats.map((s, index) => (
          <div key={index} className="statistika-user">
            {currentUser && currentUser.role === "admin" && (
                <h3>Korisnik: {s.email}</h3>
            )}
            <div className="statistika-cards">
              <Card title="Odradjeni zadaci" content={s.odradjeni} />
              <Card title="Ukupan broj zadataka" content={s.ukupno} />
              <Card title="Procenat uspešnosti" content={`${s.procent}%`} />
            </div>
          </div>
        ))
      )}
    </div>
  );
}

export default Statistika;
