import { useState } from "react";

const COLORS = {
  primary: "#009A44",
  secondary: "#EF2B2D",
  dark: "#1a1a2e",
  card: "#ffffff",
  bg: "#f4f6f9",
  text: "#333",
  muted: "#777",
  accent: "#FF8C00",
};

const CATEGORIES = ["Toutes", "Publications", "Conférences", "Formations", "Stages", "Bourses"];

const DATA = [
  { id: 1, titre: "Appel à articles - Revue Africaine de Recherche en Éducation", categorie: "Publications", domaine: "Éducation", date_limite: "2026-06-30", pays: "International", description: "La RARE lance un appel à contributions pour son numéro spécial sur l'innovation pédagogique en Afrique subsaharienne.", lien: "#" },
  { id: 2, titre: "Conférence Internationale sur l'Agriculture Durable en Afrique", categorie: "Conférences", domaine: "Agriculture", date_limite: "2026-07-15", pays: "Sénégal", description: "Soumettez vos résumés pour la CIADA 2026 à Dakar. Thème : solutions locales pour une agriculture résiliente.", lien: "#" },
  { id: 3, titre: "Bourse de recherche CODESRIA 2026", categorie: "Bourses", domaine: "Sciences Sociales", date_limite: "2026-06-01", pays: "International", description: "Le CODESRIA offre des bourses de recherche aux jeunes chercheurs africains en sciences sociales et humaines.", lien: "#" },
  { id: 4, titre: "Formation en Biostatistiques - Université de Ouagadougou", categorie: "Formations", domaine: "Santé", date_limite: "2026-05-25", pays: "Burkina Faso", description: "Formation intensive de 2 semaines en biostatistiques et épidémiologie pour les professionnels de santé.", lien: "#" },
  { id: 5, titre: "Stage de recherche - IRD Montpellier", categorie: "Stages", domaine: "Environnement", date_limite: "2026-06-15", pays: "France", description: "L'Institut de Recherche pour le Développement propose des stages de 6 mois pour chercheurs africains en environnement.", lien: "#" },
  { id: 6, titre: "Bourse Erasmus+ pour doctorants africains", categorie: "Bourses", domaine: "Tous domaines", date_limite: "2026-08-01", pays: "Europe", description: "Programme de mobilité pour doctorants souhaitant effectuer une partie de leur thèse dans une université européenne.", lien: "#" },
  { id: 7, titre: "Conférence TIC et Développement - Abidjan 2026", categorie: "Conférences", domaine: "Informatique", date_limite: "2026-07-01", pays: "Côte d'Ivoire", description: "Soumettez vos travaux sur l'impact des technologies numériques dans les pays en développement.", lien: "#" },
  { id: 8, titre: "Appel à publications - Journal of African Health Sciences", categorie: "Publications", domaine: "Santé", date_limite: "2026-09-01", pays: "International", description: "Revue indexée cherche des articles originaux sur les systèmes de santé et maladies tropicales en Afrique.", lien: "#" },
  { id: 9, titre: "Programme de formation en IA - AIMS Sénégal", categorie: "Formations", domaine: "Informatique", date_limite: "2026-06-20", pays: "Sénégal", description: "L'AIMS propose une formation de 3 semaines en intelligence artificielle et apprentissage automatique pour chercheurs africains.", lien: "#" },
];

const CAT_COLORS = {
  Publications: "#3b82f6",
  Conférences: "#8b5cf6",
  Formations: "#f59e0b",
  Stages: "#10b981",
  Bourses: "#ef4444",
};

const daysDiff = (dateStr) => {
  const d = new Date(dateStr) - new Date();
  return Math.ceil(d / (1000 * 60 * 60 * 24));
};

function Badge({ cat }) {
  return (
    <span style={{ background: CAT_COLORS[cat] || "#999", color: "#fff", borderRadius: 20, padding: "2px 10px", fontSize: 12, fontWeight: 600 }}>
      {cat}
    </span>
  );
}

function Card({ item, onClick }) {
  const days = daysDiff(item.date_limite);
  const urgent = days <= 14;
  return (
    <div onClick={() => onClick(item)} style={{ background: "#fff", borderRadius: 12, padding: 20, boxShadow: "0 2px 12px #0001", cursor: "pointer", borderLeft: `4px solid ${CAT_COLORS[item.categorie] || "#999"}`, transition: "transform 0.15s", marginBottom: 14 }}
      onMouseEnter={e => e.currentTarget.style.transform = "translateY(-2px)"}
      onMouseLeave={e => e.currentTarget.style.transform = "translateY(0)"}>
      <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-start", gap: 8, flexWrap: "wrap" }}>
        <Badge cat={item.categorie} />
        <span style={{ fontSize: 12, color: urgent ? "#ef4444" : COLORS.muted, fontWeight: urgent ? 700 : 400 }}>
          {urgent ? "⚠️ " : "📅 "}Limite : {new Date(item.date_limite).toLocaleDateString("fr-FR")} {urgent ? `(${days}j)` : ""}
        </span>
      </div>
      <h3 style={{ margin: "10px 0 6px", fontSize: 15, color: COLORS.dark, lineHeight: 1.4 }}>{item.titre}</h3>
      <p style={{ margin: 0, fontSize: 13, color: COLORS.muted, lineHeight: 1.5 }}>{item.description.slice(0, 100)}...</p>
      <div style={{ marginTop: 10, display: "flex", gap: 10, fontSize: 12, color: COLORS.muted }}>
        <span>🌍 {item.pays}</span>
        <span>📚 {item.domaine}</span>
      </div>
    </div>
  );
}

function Modal({ item, onClose }) {
  if (!item) return null;
  return (
    <div style={{ position: "fixed", inset: 0, background: "#0007", zIndex: 100, display: "flex", alignItems: "center", justifyContent: "center", padding: 16 }} onClick={onClose}>
      <div style={{ background: "#fff", borderRadius: 16, padding: 28, maxWidth: 560, width: "100%", maxHeight: "80vh", overflowY: "auto" }} onClick={e => e.stopPropagation()}>
        <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: 16 }}>
          <Badge cat={item.categorie} />
          <button onClick={onClose} style={{ border: "none", background: "none", fontSize: 22, cursor: "pointer", color: COLORS.muted }}>✕</button>
        </div>
        <h2 style={{ margin: "0 0 12px", color: COLORS.dark, fontSize: 18 }}>{item.titre}</h2>
        <p style={{ color: COLORS.text, lineHeight: 1.7, fontSize: 14 }}>{item.description}</p>
        <div style={{ display: "flex", flexDirection: "column", gap: 8, marginTop: 16, fontSize: 14 }}>
          <div>📅 <strong>Date limite :</strong> {new Date(item.date_limite).toLocaleDateString("fr-FR")}</div>
          <div>🌍 <strong>Pays :</strong> {item.pays}</div>
          <div>📚 <strong>Domaine :</strong> {item.domaine}</div>
        </div>
        <a href={item.lien} style={{ display: "inline-block", marginTop: 20, background: COLORS.primary, color: "#fff", padding: "10px 24px", borderRadius: 8, textDecoration: "none", fontWeight: 600 }}>
          Voir l'opportunité →
        </a>
      </div>
    </div>
  );
}

function AIAssistant() {
  const [open, setOpen] = useState(false);
  const [messages, setMessages] = useState([{ role: "assistant", content: "Bonjour ! Je suis votre assistant de veille scientifique. Posez-moi vos questions sur les opportunités de recherche, les bourses, comment rédiger une candidature, etc." }]);
  const [input, setInput] = useState("");
  const [loading, setLoading] = useState(false);

  const send = async () => {
    if (!input.trim() || loading) return;
    const userMsg = { role: "user", content: input };
    const newMsgs = [...messages, userMsg];
    setMessages(newMsgs);
    setInput("");
    setLoading(true);
    try {
      const res = await fetch("https://api.anthropic.com/v1/messages", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          model: "claude-sonnet-4-20250514",
          max_tokens: 1000,
          system: `Tu es un assistant spécialisé en veille scientifique pour des chercheurs au Burkina Faso et en Afrique de l'Ouest. Tu aides à trouver des opportunités (bourses, conférences, publications, stages, formations), à rédiger des lettres de motivation, des résumés scientifiques, et à comprendre les processus de candidature. Réponds toujours en français, de manière claire, concise et bienveillante. Voici les opportunités actuelles disponibles sur la plateforme : ${JSON.stringify(DATA)}`,
          messages: newMsgs.map(m => ({ role: m.role, content: m.content })),
        }),
      });
      const data = await res.json();
      const reply = data.content?.find(b => b.type === "text")?.text || "Désolé, je n'ai pas pu répondre.";
      setMessages(prev => [...prev, { role: "assistant", content: reply }]);
    } catch {
      setMessages(prev => [...prev, { role: "assistant", content: "Erreur de connexion. Veuillez réessayer." }]);
    }
    setLoading(false);
  };

  return (
    <>
      <button onClick={() => setOpen(o => !o)} style={{ position: "fixed", bottom: 24, right: 24, background: COLORS.primary, color: "#fff", border: "none", borderRadius: "50%", width: 56, height: 56, fontSize: 26, cursor: "pointer", boxShadow: "0 4px 16px #0003", zIndex: 90 }}>
        {open ? "✕" : "🤖"}
      </button>
      {open && (
        <div style={{ position: "fixed", bottom: 90, right: 24, width: 340, background: "#fff", borderRadius: 16, boxShadow: "0 8px 32px #0002", zIndex: 90, display: "flex", flexDirection: "column", maxHeight: 480 }}>
          <div style={{ background: COLORS.primary, color: "#fff", padding: "14px 18px", borderRadius: "16px 16px 0 0", fontWeight: 700, fontSize: 15 }}>
            🤖 Assistant Scientifique
          </div>
          <div style={{ flex: 1, overflowY: "auto", padding: 14, display: "flex", flexDirection: "column", gap: 10 }}>
            {messages.map((m, i) => (
              <div key={i} style={{ alignSelf: m.role === "user" ? "flex-end" : "flex-start", background: m.role === "user" ? COLORS.primary : "#f0f0f0", color: m.role === "user" ? "#fff" : COLORS.text, padding: "8px 14px", borderRadius: 12, maxWidth: "85%", fontSize: 13, lineHeight: 1.5 }}>
                {m.content}
              </div>
            ))}
            {loading && <div style={{ alignSelf: "flex-start", color: COLORS.muted, fontSize: 13 }}>⏳ En cours...</div>}
          </div>
          <div style={{ padding: 10, borderTop: "1px solid #eee", display: "flex", gap: 8 }}>
            <input value={input} onChange={e => setInput(e.target.value)} onKeyDown={e => e.key === "Enter" && send()} placeholder="Posez votre question..." style={{ flex: 1, padding: "8px 12px", borderRadius: 8, border: "1px solid #ddd", fontSize: 13, outline: "none" }} />
            <button onClick={send} disabled={loading} style={{ background: COLORS.primary, color: "#fff", border: "none", borderRadius: 8, padding: "8px 14px", cursor: "pointer", fontWeight: 700 }}>→</button>
          </div>
        </div>
      )}
    </>
  );
}

export default function App() {
  const [cat, setCat] = useState("Toutes");
  const [search, setSearch] = useState("");
  const [selected, setSelected] = useState(null);

  const filtered = DATA.filter(d =>
    (cat === "Toutes" || d.categorie === cat) &&
    (d.titre.toLowerCase().includes(search.toLowerCase()) || d.domaine.toLowerCase().includes(search.toLowerCase()) || d.pays.toLowerCase().includes(search.toLowerCase()))
  );

  const stats = CATEGORIES.slice(1).map(c => ({ name: c, count: DATA.filter(d => d.categorie === c).length }));

  return (
    <div style={{ minHeight: "100vh", background: COLORS.bg, fontFamily: "'Segoe UI', sans-serif" }}>
      {/* Header */}
      <div style={{ background: `linear-gradient(135deg, ${COLORS.dark}, ${COLORS.primary})`, color: "#fff", padding: "24px 24px 32px" }}>
        <div style={{ maxWidth: 800, margin: "0 auto" }}>
          <div style={{ display: "flex", alignItems: "center", gap: 12, marginBottom: 6 }}>
            <span style={{ fontSize: 32 }}>🔬</span>
            <div>
              <h1 style={{ margin: 0, fontSize: 22, fontWeight: 800 }}>VeilleSci Burkina</h1>
              <p style={{ margin: 0, fontSize: 13, opacity: 0.8 }}>Votre portail de veille scientifique</p>
            </div>
          </div>
          <input value={search} onChange={e => setSearch(e.target.value)} placeholder="🔍 Rechercher par titre, domaine ou pays..." style={{ width: "100%", marginTop: 18, padding: "12px 16px", borderRadius: 10, border: "none", fontSize: 14, boxSizing: "border-box", outline: "none" }} />
        </div>
      </div>

      <div style={{ maxWidth: 800, margin: "0 auto", padding: "0 16px 80px" }}>
        {/* Stats */}
        <div style={{ display: "flex", gap: 10, flexWrap: "wrap", margin: "20px 0" }}>
          {stats.map(s => (
            <div key={s.name} style={{ background: "#fff", borderRadius: 10, padding: "10px 16px", flex: 1, minWidth: 100, textAlign: "center", boxShadow: "0 1px 6px #0001" }}>
              <div style={{ fontSize: 22, fontWeight: 800, color: CAT_COLORS[s.name] }}>{s.count}</div>
              <div style={{ fontSize: 11, color: COLORS.muted }}>{s.name}</div>
            </div>
          ))}
        </div>

        {/* Filtres */}
        <div style={{ display: "flex", gap: 8, flexWrap: "wrap", marginBottom: 20 }}>
          {CATEGORIES.map(c => (
            <button key={c} onClick={() => setCat(c)} style={{ padding: "7px 16px", borderRadius: 20, border: "none", cursor: "pointer", fontWeight: 600, fontSize: 13, background: cat === c ? COLORS.primary : "#fff", color: cat === c ? "#fff" : COLORS.text, boxShadow: "0 1px 4px #0001" }}>
              {c}
            </button>
          ))}
        </div>

        {/* Résultats */}
        <div style={{ color: COLORS.muted, fontSize: 13, marginBottom: 12 }}>{filtered.length} opportunité(s) trouvée(s)</div>
        {filtered.length === 0 ? (
          <div style={{ textAlign: "center", padding: 40, color: COLORS.muted }}>Aucune opportunité trouvée.</div>
        ) : (
          filtered.map(item => <Card key={item.id} item={item} onClick={setSelected} />)
        )}
      </div>

      <Modal item={selected} onClose={() => setSelected(null)} />
      <AIAssistant />
    </div>
  );
}