import { useState, useEffect } from "react";

// ─── Constantes ───────────────────────────────────────────
const API_BASE = "/api/v1";   // Même domaine = pas de CORS

const CATEGORIES = ["Toutes", "Publications", "Conférences", "Formations", "Stages", "Bourses"];
const CAT_COLORS = {
    Publications: "#3b82f6",
    Conférences:  "#8b5cf6",
    Formations:   "#f59e0b",
    Stages:       "#10b981",
    Bourses:      "#ef4444",
};
const COLORS = { primary: "#009A44", dark: "#1a1a2e", muted: "#777", bg: "#f4f6f9" };

// ─── Utilitaires ──────────────────────────────────────────
const joursRestants = (date) =>
    Math.ceil((new Date(date) - new Date()) / 86400000);

// Appel API centralisé avec gestion d'erreur
const apiFetch = async (url, params = {}, method = 'GET', body = null) => {
    const query = new URLSearchParams(method === 'GET' ? params : {}).toString();
    const fullUrl = `${API_BASE}${url}${query ? "?" + query : ""}`;

    const options = {
        method,
        headers: {
            "Accept":       "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content ?? "",
        },
    };

    if (body) options.body = JSON.stringify(body);

    const res = await fetch(fullUrl, options);

    if (!res.ok) throw new Error(`Erreur HTTP ${res.status}`);
    return res.json();
};

// ─── Composant Badge ──────────────────────────────────────
function Badge({ cat }) {
    return (
        <span style={{
            background: CAT_COLORS[cat] || "#999", color: "#fff",
            borderRadius: 20, padding: "2px 10px", fontSize: 12, fontWeight: 600,
        }}>
            {cat}
        </span>
    );
}

// ─── Composant Card ───────────────────────────────────────
function Card({ item, onClick, isFavorited, onToggleFavorite }) {
    const jours = joursRestants(item.date_limite);
    const urgent = jours <= 14;
    return (
        <div
            onClick={() => onClick(item)}
            style={{
                background: "#fff", borderRadius: 12, padding: 18,
                cursor: "pointer",
                borderTop: `4px solid ${CAT_COLORS[item.categorie] || "#999"}`,
                boxShadow: "0 2px 12px rgba(0,0,0,0.06)",
                transition: "transform 0.15s, box-shadow 0.15s",
                display: "flex",
                flexDirection: "column",
                height: "100%",
                position: "relative",
            }}
            onMouseEnter={e => {
                e.currentTarget.style.transform = "translateY(-4px)";
                e.currentTarget.style.boxShadow = "0 8px 24px rgba(0,0,0,0.12)";
            }}
            onMouseLeave={e => {
                e.currentTarget.style.transform = "translateY(0)";
                e.currentTarget.style.boxShadow = "0 2px 12px rgba(0,0,0,0.06)";
            }}
        >
            {/* Bouton Favori */}
            <button 
                onClick={(e) => {
                    e.stopPropagation();
                    onToggleFavorite(item.id);
                }}
                style={{
                    position: "absolute",
                    top: 10,
                    right: 10,
                    background: "none",
                    border: "none",
                    fontSize: "20px",
                    cursor: "pointer",
                    padding: "4px",
                    transition: "transform 0.2s",
                }}
                onMouseEnter={e => e.currentTarget.style.transform = "scale(1.2)"}
                onMouseLeave={e => e.currentTarget.style.transform = "scale(1)"}
                title={isFavorited ? "Retirer des favoris" : "Ajouter aux favoris"}
            >
                {isFavorited ? "❤️" : "🤍"}
            </button>

            <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-start", gap: 8, marginBottom: 12, paddingRight: 20 }}>
                <Badge cat={item.categorie} />
                <span style={{ fontSize: 11, color: urgent ? "#ef4444" : COLORS.muted, fontWeight: urgent ? 700 : 400, whiteSpace: "nowrap" }}>
                    {urgent ? "⚠️" : "📅"}
                </span>
            </div>
            <h3 style={{ margin: "0 0 8px", fontSize: 14, color: COLORS.dark, fontWeight: 700, lineHeight: 1.4 }}>{item.titre.slice(0, 50)}</h3>
            <p style={{ margin: "0 0 12px", fontSize: 12, color: COLORS.muted, lineHeight: 1.5, flex: 1 }}>
                {item.description?.slice(0, 80)}...
            </p>
            <div style={{ fontSize: 11, color: COLORS.muted, display: "flex", flexDirection: "column", gap: 6 }}>
                <div style={{ display: "flex", alignItems: "center", gap: 4 }}>
                    <span>🌍</span> <span>{item.pays}</span>
                </div>
                <div style={{ display: "flex", alignItems: "center", gap: 4 }}>
                    <span>📚</span> <span>{item.domaine}</span>
                </div>
                <div style={{ display: "flex", alignItems: "center", gap: 4, marginTop: 4 }}>
                    <span>{urgent ? "⏰" : "📅"}</span>
                    <span style={{ color: urgent ? "#ef4444" : COLORS.muted, fontWeight: urgent ? 600 : 400 }}>
                        {new Date(item.date_limite).toLocaleDateString("fr-FR")}
                        {urgent ? ` (${jours}j)` : ""}
                    </span>
                </div>
            </div>
        </div>
    );
}

// ─── Composant Modal ──────────────────────────────────────
function Modal({ item, onClose }) {
    if (!item) return null;
    return (
        <div
            onClick={onClose}
            style={{ position: "fixed", inset: 0, background: "rgba(0,0,0,0.5)", zIndex: 100, display: "flex", alignItems: "center", justifyContent: "center", padding: 16 }}
        >
            <div
                onClick={e => e.stopPropagation()}
                style={{ background: "#fff", borderRadius: 16, padding: 28, maxWidth: 560, width: "100%", maxHeight: "80vh", overflowY: "auto" }}
            >
                <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: 16 }}>
                    <Badge cat={item.categorie} />
                    <button onClick={onClose} style={{ border: "none", background: "none", fontSize: 22, cursor: "pointer", color: COLORS.muted }}>✕</button>
                </div>
                <h2 style={{ margin: "0 0 12px", color: COLORS.dark, fontSize: 18 }}>{item.titre}</h2>
                <p style={{ color: "#333", lineHeight: 1.7, fontSize: 14 }}>{item.description}</p>
                <div style={{ display: "flex", flexDirection: "column", gap: 8, marginTop: 16, fontSize: 14 }}>
                    <div>📅 <strong>Date limite :</strong> {new Date(item.date_limite).toLocaleDateString("fr-FR")}</div>
                    <div>🌍 <strong>Pays :</strong> {item.pays}</div>
                    <div>📚 <strong>Domaine :</strong> {item.domaine}</div>
                </div>
                {item.lien && (
                    <a href={item.lien} target="_blank" rel="noreferrer"
                        style={{ display: "inline-block", marginTop: 20, background: COLORS.primary, color: "#fff", padding: "10px 24px", borderRadius: 8, textDecoration: "none", fontWeight: 600 }}>
                        Voir l'opportunité →
                    </a>
                )}
            </div>
        </div>
    );
}

// ─── Composant Assistant IA ───────────────────────────────
function AIAssistant() {
    const [open, setOpen] = useState(false);
    const [messages, setMessages] = useState([{
        role: "assistant",
        content: "Bonjour ! Je suis votre assistant de veille scientifique. Comment puis-je vous aider ?",
    }]);
    const [input, setInput]   = useState("");
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
                    system: "Tu es un assistant spécialisé en veille scientifique pour des chercheurs au Burkina Faso. Tu aides à trouver des opportunités (bourses, conférences, publications, stages, formations) et à rédiger des candidatures. Réponds en français, de manière claire et bienveillante.",
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
            <button onClick={() => setOpen(o => !o)}
                style={{ position: "fixed", bottom: 24, right: 24, background: COLORS.primary, color: "#fff", border: "none", borderRadius: "50%", width: 56, height: 56, fontSize: 26, cursor: "pointer", boxShadow: "0 4px 16px rgba(0,0,0,0.2)", zIndex: 90 }}>
                {open ? "✕" : "🤖"}
            </button>
            {open && (
                <div style={{ position: "fixed", bottom: 90, right: 24, width: 340, background: "#fff", borderRadius: 16, boxShadow: "0 8px 32px rgba(0,0,0,0.15)", zIndex: 90, display: "flex", flexDirection: "column", maxHeight: 480 }}>
                    <div style={{ background: COLORS.primary, color: "#fff", padding: "14px 18px", borderRadius: "16px 16px 0 0", fontWeight: 700, fontSize: 15 }}>
                        🤖 Assistant Scientifique
                    </div>
                    <div style={{ flex: 1, overflowY: "auto", padding: 14, display: "flex", flexDirection: "column", gap: 10 }}>
                        {messages.map((m, i) => (
                            <div key={i} style={{
                                alignSelf: m.role === "user" ? "flex-end" : "flex-start",
                                background: m.role === "user" ? COLORS.primary : "#f0f0f0",
                                color: m.role === "user" ? "#fff" : "#333",
                                padding: "8px 14px", borderRadius: 12,
                                maxWidth: "85%", fontSize: 13, lineHeight: 1.5,
                            }}>
                                {m.content}
                            </div>
                        ))}
                        {loading && <div style={{ alignSelf: "flex-start", color: COLORS.muted, fontSize: 13 }}>⏳ En cours...</div>}
                    </div>
                    <div style={{ padding: 10, borderTop: "1px solid #eee", display: "flex", gap: 8 }}>
                        <input value={input} onChange={e => setInput(e.target.value)} onKeyDown={e => e.key === "Enter" && send()}
                            placeholder="Posez votre question..."
                            style={{ flex: 1, padding: "8px 12px", borderRadius: 8, border: "1px solid #ddd", fontSize: 13, outline: "none" }} />
                        <button onClick={send} disabled={loading}
                            style={{ background: COLORS.primary, color: "#fff", border: "none", borderRadius: 8, padding: "8px 14px", cursor: "pointer", fontWeight: 700 }}>
                            →
                        </button>
                    </div>
                </div>
            )}
        </>
    );
}

// ─── Composant Principal ──────────────────────────────────
export default function App() {
    const [opportunites, setOpportunites] = useState([]);
    const [stats, setStats]               = useState({});
    const [cat, setCat]                   = useState("Toutes");
    const [search, setSearch]             = useState("");
    const [loading, setLoading]           = useState(true);
    const [erreur, setErreur]             = useState(null);
    const [selected, setSelected]         = useState(null);
    const [currentPage, setCurrentPage]   = useState(1);
    const [favoris, setFavoris]           = useState(new Set());
    const [user, setUser]                 = useState(null);
    const ITEMS_PER_PAGE = 10;

    // Charger les opportunités depuis l'API Laravel
    useEffect(() => {
        const charger = async () => {
            setLoading(true);
            setErreur(null);
            setCurrentPage(1); // Réinitialiser la page
            try {
                const params = {};
                if (cat !== "Toutes") params.categorie = cat;
                if (search.trim())    params.search    = search;

                const data = await apiFetch("/opportunites", params);
                setOpportunites(data.data ?? []);
            } catch (err) {
                console.error("Erreur API:", err);
                setErreur(`Impossible de charger les opportunités. (${err.message})`);
            } finally {
                setLoading(false);
            }
        };
        charger();
    }, [cat, search]);

    // Charger les statistiques
    useEffect(() => {
        apiFetch("/statistiques")
            .then(data => setStats(data.data ?? {}))
            .catch(() => {});
    }, []);

    // Charger les favoris de l'utilisateur
    useEffect(() => {
        const chargerFavoris = async () => {
            try {
                const data = await apiFetch("/favoris");
                const favorisIds = new Set(data.data?.map(opp => opp.id) || []);
                setFavoris(favorisIds);
            } catch {
                // Pas d'erreur à afficher, l'utilisateur peut continuer
                setFavoris(new Set());
            }
        };
        chargerFavoris();
    }, []);

    // Basculer le statut favori d'une opportunité
    const toggleFavorite = async (opportuniteId) => {
        try {
            const response = await apiFetch(`/favoris/${opportuniteId}`, {}, 'POST');
            
            setFavoris(prev => {
                const newFavoris = new Set(prev);
                if (response.favorited) {
                    newFavoris.add(opportuniteId);
                } else {
                    newFavoris.delete(opportuniteId);
                }
                return newFavoris;
            });
        } catch (err) {
            console.error("Erreur toggle favori:", err);
        }
    };

    return (
        <div style={{ minHeight: "100vh", background: COLORS.bg, fontFamily: "'Segoe UI', sans-serif" }}>

            {/* Header académique */}
            <div style={{ background: "#fff", borderBottom: "1px solid #e2e8f0" }}>

                {/* Barre supérieure */}
                <div style={{ background: "#1a3a5c", padding: "7px 32px", display: "flex", justifyContent: "space-between", alignItems: "center" }}>
                    <span style={{ color: "rgba(255,255,255,0.75)", fontSize: 12 }}>
                        🇧🇫 Portail National de Veille Scientifique — Burkina Faso
                    </span>
                    <a href="/" style={{ color: "rgba(255,255,255,0.65)", fontSize: 12, textDecoration: "none" }}>
                        ← Retour à l'accueil
                    </a>
                </div>

                {/* Logo + titre */}
                <div style={{ maxWidth: 860, margin: "0 auto", padding: "20px 24px 0", display: "flex", alignItems: "center", gap: 18 }}>
                    {/* Emblème */}
                    <div style={{
                        width: 64, height: 64, borderRadius: "50%",
                        background: "linear-gradient(135deg, #1a3a5c, #009A44)",
                        display: "flex", alignItems: "center", justifyContent: "center",
                        fontSize: 28, flexShrink: 0,
                        boxShadow: "0 2px 12px rgba(0,0,0,0.15)"
                    }}>🔬</div>

                    <div style={{ flex: 1 }}>
                        <div style={{ fontSize: 11, fontWeight: 700, color: "#009A44", letterSpacing: "1.5px", textTransform: "uppercase", marginBottom: 2 }}>
                            Plateforme de Veille Scientifique
                        </div>
                        <h1 style={{ margin: 0, fontSize: 26, fontWeight: 900, color: "#1a3a5c", letterSpacing: "-0.5px" }}>
                            VeilleSci <span style={{ color: "#009A44" }}>Burkina</span>
                        </h1>
                        <p style={{ margin: "2px 0 0", fontSize: 12, color: "#64748b" }}>
                            Publications · Conférences · Bourses · Formations · Stages
                        </p>
                    </div>

                    {/* Badge accréditation */}
                    <div style={{
                        display: "flex", flexDirection: "column", alignItems: "center",
                        padding: "8px 14px", border: "1.5px solid #e2e8f0",
                        borderRadius: 10, fontSize: 11, color: "#64748b", textAlign: "center",
                        lineHeight: 1.4
                    }}>
                        <span style={{ fontSize: 18 }}>🎓</span>
                        <span style={{ fontWeight: 700, color: "#1a3a5c" }}>Accès libre</span>
                        <span>Chercheurs BF</span>
                    </div>
                </div>

                {/* Barre de recherche */}
                <div style={{ maxWidth: 860, margin: "0 auto", padding: "16px 24px 20px" }}>
                    <div style={{ position: "relative" }}>
                        <span style={{ position: "absolute", left: 14, top: "50%", transform: "translateY(-50%)", fontSize: 16, color: "#94a3b8" }}>🔍</span>
                        <input
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            placeholder="Rechercher par titre, domaine, pays..."
                            style={{
                                width: "100%", padding: "12px 16px 12px 42px",
                                borderRadius: 8, fontSize: 14, boxSizing: "border-box",
                                border: "1.5px solid #e2e8f0", outline: "none",
                                background: "#f8fafc", color: "#1e293b",
                                transition: "border-color 0.2s",
                            }}
                            onFocus={e => e.target.style.borderColor = "#009A44"}
                            onBlur={e  => e.target.style.borderColor = "#e2e8f0"}
                        />
                    </div>
                </div>

                {/* Onglets catégories */}
                <div style={{ maxWidth: 860, margin: "0 auto", padding: "0 24px", display: "flex", gap: 0, overflowX: "auto", borderTop: "1px solid #e2e8f0" }}>
                    {CATEGORIES.map(c => (
                        <button key={c} onClick={() => setCat(c)} style={{
                            padding: "12px 18px", border: "none", cursor: "pointer",
                            background: "transparent", fontSize: 13, fontWeight: 600, whiteSpace: "nowrap",
                            color: cat === c ? "#009A44" : "#64748b",
                            borderBottom: cat === c ? "2.5px solid #009A44" : "2.5px solid transparent",
                            transition: "all 0.2s",
                        }}>
                            {c === "Toutes" ? "📋 Toutes" :
                             c === "Publications" ? "📄 Publications" :
                             c === "Conférences"  ? "🎤 Conférences"  :
                             c === "Formations"   ? "📚 Formations"   :
                             c === "Stages"       ? "🏢 Stages"       : "🎓 Bourses"}
                        </button>
                    ))}
                </div>
            </div>

            <div style={{ maxWidth: 800, margin: "0 auto", padding: "16px 16px 100px" }}>

                {/* Stats */}
                {Object.keys(stats).length > 0 && (
                    <div style={{ display: "flex", gap: 10, flexWrap: "wrap", marginBottom: 16 }}>
                        {CATEGORIES.slice(1).map(c => {
                            const key = c.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                            return (
                                <div key={c} style={{ background: "#fff", borderRadius: 10, padding: "10px 16px", flex: 1, minWidth: 90, textAlign: "center", boxShadow: "0 1px 6px rgba(0,0,0,0.06)" }}>
                                    <div style={{ fontSize: 20, fontWeight: 800, color: CAT_COLORS[c] }}>{stats[key] ?? 0}</div>
                                    <div style={{ fontSize: 11, color: COLORS.muted }}>{c}</div>
                                </div>
                            );
                        })}
                    </div>
                )}

                {/* Filtres */}
                <div style={{ display: "flex", gap: 8, flexWrap: "wrap", marginBottom: 16 }}>
                    {CATEGORIES.map(c => (
                        <button key={c} onClick={() => setCat(c)}
                            style={{ padding: "7px 16px", borderRadius: 20, border: "none", cursor: "pointer", fontWeight: 600, fontSize: 13, background: cat === c ? COLORS.primary : "#fff", color: cat === c ? "#fff" : "#333", boxShadow: "0 1px 4px rgba(0,0,0,0.08)" }}>
                            {c}
                        </button>
                    ))}
                </div>

                {/* États */}
                {loading && (
                    <div style={{ textAlign: "center", padding: 60, color: COLORS.muted }}>
                        ⏳ Chargement des opportunités...
                    </div>
                )}

                {erreur && (
                    <div style={{ background: "#fff", borderRadius: 12, padding: 24, textAlign: "center", color: "#ef4444", border: "1px solid #fecaca" }}>
                        <div style={{ fontSize: 32, marginBottom: 12 }}>❌</div>
                        <strong>Erreur de chargement</strong>
                        <p style={{ marginTop: 8, fontSize: 14, color: COLORS.muted }}>{erreur}</p>
                        <p style={{ fontSize: 13, marginTop: 8 }}>
                            Vérifiez que <code>php artisan migrate</code> et <code>php artisan db:seed</code> ont été exécutés.
                        </p>
                        <button onClick={() => window.location.reload()}
                            style={{ marginTop: 16, background: COLORS.primary, color: "#fff", border: "none", borderRadius: 8, padding: "10px 20px", cursor: "pointer", fontWeight: 600 }}>
                            Réessayer
                        </button>
                    </div>
                )}

                {/* Liste */}
                {!loading && !erreur && (
                    <>
                        <div style={{ color: COLORS.muted, fontSize: 13, marginBottom: 12 }}>
                            {opportunites.length} opportunité(s) trouvée(s)
                        </div>
                        {opportunites.length === 0 ? (
                            <div style={{ textAlign: "center", padding: 60, color: COLORS.muted }}>
                                Aucune opportunité trouvée.
                            </div>
                        ) : (
                            <>
                                <div style={{
                                    display: "grid",
                                    gridTemplateColumns: "repeat(auto-fill, minmax(280px, 1fr))",
                                    gap: "20px",
                                    marginBottom: 24
                                }}>
                                    {opportunites.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE).map(item => (
                                        <Card 
                                            key={item.id} 
                                            item={item} 
                                            onClick={setSelected}
                                            isFavorited={favoris.has(item.id)}
                                            onToggleFavorite={toggleFavorite}
                                        />
                                    ))}
                                </div>
                                
                                {/* Pagination */}
                                <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginTop: 24, padding: "16px 0", borderTop: "1px solid #e2e8f0" }}>
                                    <div style={{ fontSize: 13, color: COLORS.muted }}>
                                        Page {currentPage} sur {Math.ceil(opportunites.length / ITEMS_PER_PAGE)}
                                    </div>
                                    <div style={{ display: "flex", gap: 8 }}>
                                        <button 
                                            onClick={() => setCurrentPage(p => Math.max(1, p - 1))}
                                            disabled={currentPage === 1}
                                            style={{
                                                padding: "8px 16px", borderRadius: 8, border: "1px solid #e2e8f0",
                                                background: currentPage === 1 ? "#f8fafc" : "#fff",
                                                color: currentPage === 1 ? COLORS.muted : "#1a3a5c",
                                                cursor: currentPage === 1 ? "not-allowed" : "pointer",
                                                fontWeight: 600, fontSize: 13,
                                                transition: "all 0.2s",
                                            }}>
                                            ← Précédent
                                        </button>
                                        <button 
                                            onClick={() => setCurrentPage(p => Math.min(Math.ceil(opportunites.length / ITEMS_PER_PAGE), p + 1))}
                                            disabled={currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE)}
                                            style={{
                                                padding: "8px 16px", borderRadius: 8, border: "1px solid #e2e8f0",
                                                background: currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE) ? "#f8fafc" : COLORS.primary,
                                                color: currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE) ? COLORS.muted : "#fff",
                                                cursor: currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE) ? "not-allowed" : "pointer",
                                                fontWeight: 600, fontSize: 13,
                                                transition: "all 0.2s",
                                            }}>
                                            Suivant →
                                        </button>
                                    </div>
                                </div>
                            </>
                        )}
                    </>
                )}
            </div>

            {/* Footer */}
            <footer style={{
                background: "rgba(0,0,0,0.6)", 
                borderTop: "2px solid rgba(201,169,97,0.15)",
                padding: "32px 40px", 
                display: "flex", 
                justifyContent: "space-between",
                alignItems: "center", 
                flexWrap: "wrap", 
                gap: "12px",
                marginTop: "0px",
                color: "#fff",
                fontSize: "13px"
            }}>
                <div style={{ display: "flex", alignItems: "center", gap: "10px", fontSize: "16px", fontWeight: "800" }}>
                    <div style={{
                        width: "28px", 
                        height: "28px", 
                        borderRadius: "6px",
                        background: "linear-gradient(135deg, #1a3a5c, #009A44)",
                        display: "flex", 
                        alignItems: "center", 
                        justifyContent: "center",
                        fontSize: "14px"
                    }}>🔬</div>
                    VeilleSci<span style={{ color: "#c9a961" }}>BF</span>
                </div>
                <p style={{ margin: 0, color: "#8b92a0" }}>© 2026 VeilleSci Burkina — Tous droits réservés</p>
                <p style={{ margin: 0, color: "#4ade80" }}> Burkina Faso</p>
            </footer>

            <Modal item={selected} onClose={() => setSelected(null)} />
            <AIAssistant />
        </div>
    );
}