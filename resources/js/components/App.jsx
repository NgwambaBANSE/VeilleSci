import { useState, useEffect } from "react";

// ─── Config Laravel (user connecté ou null) ───────────────
const AppConfig = window.AppConfig || { user: null, csrfToken: "", logoutUrl: "/logout" };

// ─── Constantes ───────────────────────────────────────────
const API_BASE = "/api/v1";

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

const apiFetch = async (url, params = {}, method = 'GET', body = null) => {
    const query = new URLSearchParams(method === 'GET' ? params : {}).toString();
    const fullUrl = `${API_BASE}${url}${query ? "?" + query : ""}`;
    const options = {
        method,
        headers: {
            "Accept":       "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": AppConfig.csrfToken,
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

// ─── Composant AuthBar ────────────────────────────────────
function AuthBar() {
    const { user, csrfToken, logoutUrl } = AppConfig;
    return (
        <div style={{ display: "flex", alignItems: "center", gap: 10 }}>
            {user ? (
                <>
                    {/* Chip utilisateur */}
                    <div style={{
                        display: "flex", alignItems: "center", gap: 8,
                        background: "rgba(255,255,255,0.1)", borderRadius: 20,
                        padding: "4px 12px 4px 6px",
                    }}>
                        <div style={{
                            width: 26, height: 26, borderRadius: "50%",
                            background: "#009A44", color: "#fff",
                            fontSize: 12, fontWeight: 700,
                            display: "flex", alignItems: "center", justifyContent: "center",
                        }}>
                            {user.initial}
                        </div>
                        <span style={{ color: "rgba(255,255,255,0.9)", fontSize: 12, fontWeight: 500 }}>
                            {user.name}
                        </span>
                    </div>

                    {/* Bouton déconnexion */}
                    <form method="POST" action={logoutUrl} style={{ margin: 0 }}>
                        <input type="hidden" name="_token" value={csrfToken} />
                        <button type="submit" style={{
                            background: "rgba(239,43,45,0.18)",
                            border: "1px solid rgba(239,43,45,0.45)",
                            color: "#fca5a5", borderRadius: 6,
                            padding: "5px 14px", fontSize: 12,
                            cursor: "pointer", fontFamily: "inherit",
                            transition: "all .2s",
                        }}
                            onMouseEnter={e => e.currentTarget.style.background = "rgba(239,43,45,0.32)"}
                            onMouseLeave={e => e.currentTarget.style.background = "rgba(239,43,45,0.18)"}
                        >
                            🚪 Déconnexion
                        </button>
                    </form>
                </>
            ) : (
                <>
                    {/* Bouton connexion */}
                    <a href="/login" style={{
                        color: "rgba(255,255,255,0.8)", fontSize: 12, fontWeight: 500,
                        textDecoration: "none", padding: "5px 14px", borderRadius: 6,
                        border: "1px solid rgba(255,255,255,0.25)",
                        transition: "all .2s",
                    }}
                        onMouseEnter={e => e.currentTarget.style.background = "rgba(255,255,255,0.1)"}
                        onMouseLeave={e => e.currentTarget.style.background = "transparent"}
                    >
                        🔑 Se connecter
                    </a>

                    {/* Bouton inscription */}
                    <a href="/register" style={{
                        background: "#009A44", color: "#fff",
                        fontSize: 12, fontWeight: 700,
                        textDecoration: "none", padding: "5px 14px", borderRadius: 6,
                        transition: "background .2s",
                    }}
                        onMouseEnter={e => e.currentTarget.style.background = "#007a35"}
                        onMouseLeave={e => e.currentTarget.style.background = "#009A44"}
                    >
                        ✏️ Créer un compte
                    </a>
                </>
            )}
        </div>
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
                display: "flex", flexDirection: "column",
                height: "100%", position: "relative",
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
            <button
                onClick={e => { e.stopPropagation(); onToggleFavorite(item.id); }}
                style={{
                    position: "absolute", top: 10, right: 10,
                    background: "none", border: "none", fontSize: 20,
                    cursor: "pointer", padding: 4, transition: "transform 0.2s",
                }}
                onMouseEnter={e => e.currentTarget.style.transform = "scale(1.2)"}
                onMouseLeave={e => e.currentTarget.style.transform = "scale(1)"}
                title={isFavorited ? "Retirer des favoris" : "Ajouter aux favoris"}
            >
                {isFavorited ? "❤️" : "🤍"}
            </button>

            <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-start", gap: 8, marginBottom: 12, paddingRight: 20 }}>
                <Badge cat={item.categorie} />
                <span style={{ fontSize: 11, color: urgent ? "#ef4444" : COLORS.muted, fontWeight: urgent ? 700 : 400 }}>
                    {urgent ? "⚠️" : "📅"}
                </span>
            </div>
            <h3 style={{ margin: "0 0 8px", fontSize: 14, color: COLORS.dark, fontWeight: 700, lineHeight: 1.4 }}>
                {item.titre.slice(0, 50)}
            </h3>
            <p style={{ margin: "0 0 12px", fontSize: 12, color: COLORS.muted, lineHeight: 1.5, flex: 1 }}>
                {item.description?.slice(0, 80)}...
            </p>
            <div style={{ fontSize: 11, color: COLORS.muted, display: "flex", flexDirection: "column", gap: 6 }}>
                <div style={{ display: "flex", alignItems: "center", gap: 4 }}>🌍 {item.pays}</div>
                <div style={{ display: "flex", alignItems: "center", gap: 4 }}>📚 {item.domaine}</div>
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
        <div onClick={onClose} style={{ position: "fixed", inset: 0, background: "rgba(0,0,0,0.5)", zIndex: 100, display: "flex", alignItems: "center", justifyContent: "center", padding: 16 }}>
            <div onClick={e => e.stopPropagation()} style={{ background: "#fff", borderRadius: 16, padding: 28, maxWidth: 560, width: "100%", maxHeight: "80vh", overflowY: "auto" }}>
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
            <button onClick={() => setOpen(o => !o)} style={{ position: "fixed", bottom: 24, right: 24, background: COLORS.primary, color: "#fff", border: "none", borderRadius: "50%", width: 56, height: 56, fontSize: 26, cursor: "pointer", boxShadow: "0 4px 16px rgba(0,0,0,0.2)", zIndex: 90 }}>
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
    const ITEMS_PER_PAGE = 10;

    useEffect(() => {
        const charger = async () => {
            setLoading(true); setErreur(null); setCurrentPage(1);
            try {
                const params = {};
                if (cat !== "Toutes") params.categorie = cat;
                if (search.trim())    params.search    = search;
                const data = await apiFetch("/opportunites", params);
                setOpportunites(data.data ?? []);
            } catch (err) {
                setErreur(`Impossible de charger les opportunités. (${err.message})`);
            } finally {
                setLoading(false);
            }
        };
        charger();
    }, [cat, search]);

    useEffect(() => {
        apiFetch("/statistiques").then(data => setStats(data.data ?? {})).catch(() => {});
    }, []);

    useEffect(() => {
        apiFetch("/favoris").then(data => setFavoris(new Set(data.data?.map(o => o.id) || []))).catch(() => {});
    }, []);

    const toggleFavorite = async (id) => {
        try {
            const res = await apiFetch(`/favoris/${id}`, {}, 'POST');
            setFavoris(prev => {
                const next = new Set(prev);
                res.favorited ? next.add(id) : next.delete(id);
                return next;
            });
        } catch {}
    };

    return (
        <div style={{ minHeight: "100vh", background: COLORS.bg, fontFamily: "'Segoe UI', sans-serif" }}>

            {/* ── HEADER ─────────────────────────────────── */}
            <div style={{ background: "#fff", borderBottom: "1px solid #e2e8f0" }}>

                {/* Barre supérieure avec auth */}
                <div style={{
                    background: "#0f2540", padding: "7px 32px",
                    display: "flex", justifyContent: "space-between", alignItems: "center",
                }}>
                    <span style={{ color: "rgba(255,255,255,0.65)", fontSize: 12 }}>
                        🇧🇫 Portail National de Veille Scientifique — Burkina Faso
                    </span>

                    {/* ← Boutons connexion / déconnexion */}
                    <AuthBar />
                </div>

                {/* Logo + titre */}
                <div style={{ maxWidth: 960, margin: "0 auto", padding: "20px 24px 0", display: "flex", alignItems: "center", gap: 18 }}>
                    <div style={{
                        width: 64, height: 64, borderRadius: "50%",
                        background: "linear-gradient(135deg, #1a3a5c, #009A44)",
                        display: "flex", alignItems: "center", justifyContent: "center",
                        fontSize: 28, flexShrink: 0, boxShadow: "0 2px 12px rgba(0,0,0,0.15)",
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
                    <div style={{ display: "flex", flexDirection: "column", alignItems: "center", padding: "8px 14px", border: "1.5px solid #e2e8f0", borderRadius: 10, fontSize: 11, color: "#64748b", textAlign: "center", lineHeight: 1.4 }}>
                        <span style={{ fontSize: 18 }}>🎓</span>
                        <span style={{ fontWeight: 700, color: "#1a3a5c" }}>Accès libre</span>
                        <span>Chercheurs BF</span>
                    </div>
                </div>

                {/* Barre de recherche */}
                <div style={{ maxWidth: 960, margin: "0 auto", padding: "16px 24px 20px" }}>
                    <div style={{ position: "relative" }}>
                        <span style={{ position: "absolute", left: 14, top: "50%", transform: "translateY(-50%)", fontSize: 16, color: "#94a3b8" }}>🔍</span>
                        <input value={search} onChange={e => setSearch(e.target.value)}
                            placeholder="Rechercher par titre, domaine, pays..."
                            style={{ width: "100%", padding: "12px 16px 12px 42px", borderRadius: 8, fontSize: 14, boxSizing: "border-box", border: "1.5px solid #e2e8f0", outline: "none", background: "#f8fafc", color: "#1e293b", transition: "border-color 0.2s" }}
                            onFocus={e => e.target.style.borderColor = "#009A44"}
                            onBlur={e  => e.target.style.borderColor = "#e2e8f0"}
                        />
                    </div>
                </div>

                {/* Onglets catégories */}
                <div style={{ maxWidth: 960, margin: "0 auto", padding: "0 24px", display: "flex", overflowX: "auto", borderTop: "1px solid #e2e8f0" }}>
                    {CATEGORIES.map(c => (
                        <button key={c} onClick={() => setCat(c)} style={{
                            padding: "12px 18px", border: "none", cursor: "pointer",
                            background: "transparent", fontSize: 13, fontWeight: 600, whiteSpace: "nowrap",
                            color: cat === c ? "#009A44" : "#64748b",
                            borderBottom: cat === c ? "2.5px solid #009A44" : "2.5px solid transparent",
                            transition: "all 0.2s",
                        }}>
                            {c === "Toutes" ? "📋 Toutes" : c === "Publications" ? "📄 Publications" :
                             c === "Conférences" ? "🎤 Conférences" : c === "Formations" ? "📚 Formations" :
                             c === "Stages" ? "🏢 Stages" : "🎓 Bourses"}
                        </button>
                    ))}
                </div>
            </div>

            {/* ── CONTENU ────────────────────────────────── */}
            <div style={{ maxWidth: 960, margin: "0 auto", padding: "20px 16px 100px" }}>

                {/* Message pour non-connectés */}
                {!AppConfig.user && (
                    <div style={{
                        background: "linear-gradient(135deg, #e8f5ef 0%, #f0fdf4 100%)",
                        border: "1.5px solid #86efac",
                        borderRadius: 12,
                        padding: "16px 20px",
                        marginBottom: 24,
                        display: "flex",
                        alignItems: "center",
                        gap: 14,
                    }}>
                        <span style={{ fontSize: 24 }}>🔒</span>
                        <div style={{ flex: 1 }}>
                            <div style={{ fontSize: 14, fontWeight: 700, color: "#059669", marginBottom: 4 }}>
                                Connectez-vous pour sauvegarder vos opportunités
                            </div>
                            <div style={{ fontSize: 13, color: "#047857", lineHeight: 1.5 }}>
                                Créez un compte gratuit pour ajouter des favoris et retrouvez vos opportunités préférées lors de votre prochaine visite.
                            </div>
                        </div>
                        <div style={{ display: "flex", gap: 8 }}>
                            <a href="/login" style={{
                                padding: "8px 16px",
                                background: "#059669",
                                color: "#fff",
                                borderRadius: 6,
                                textDecoration: "none",
                                fontSize: 13,
                                fontWeight: 600,
                                transition: "background 0.2s",
                                whiteSpace: "nowrap",
                            }}
                                onMouseEnter={e => e.currentTarget.style.background = "#047857"}
                                onMouseLeave={e => e.currentTarget.style.background = "#059669"}
                            >
                                Se connecter
                            </a>
                            <a href="/register" style={{
                                padding: "8px 16px",
                                background: "#fff",
                                color: "#059669",
                                borderRadius: 6,
                                textDecoration: "none",
                                fontSize: 13,
                                fontWeight: 600,
                                border: "1.5px solid #86efac",
                                transition: "background 0.2s",
                                whiteSpace: "nowrap",
                            }}
                                onMouseEnter={e => e.currentTarget.style.background = "#f0fdf4"}
                                onMouseLeave={e => e.currentTarget.style.background = "#fff"}
                            >
                                S'inscrire
                            </a>
                        </div>
                    </div>
                )}

                {/* Stats */}
                {Object.keys(stats).length > 0 && (
                    <div style={{ display: "flex", gap: 10, flexWrap: "wrap", marginBottom: 20 }}>
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

                {/* État chargement */}
                {loading && <div style={{ textAlign: "center", padding: 60, color: COLORS.muted }}>⏳ Chargement des opportunités...</div>}

                {/* État erreur */}
                {erreur && (
                    <div style={{ background: "#fff", borderRadius: 12, padding: 24, textAlign: "center", color: "#ef4444", border: "1px solid #fecaca" }}>
                        <div style={{ fontSize: 32, marginBottom: 12 }}>❌</div>
                        <strong>Erreur de chargement</strong>
                        <p style={{ marginTop: 8, fontSize: 14, color: COLORS.muted }}>{erreur}</p>
                        <button onClick={() => window.location.reload()}
                            style={{ marginTop: 16, background: COLORS.primary, color: "#fff", border: "none", borderRadius: 8, padding: "10px 20px", cursor: "pointer", fontWeight: 600 }}>
                            Réessayer
                        </button>
                    </div>
                )}

                {/* Liste */}
                {!loading && !erreur && (
                    <>
                        <div style={{ color: COLORS.muted, fontSize: 13, marginBottom: 14 }}>
                            {opportunites.length} opportunité(s) trouvée(s)
                        </div>
                        {opportunites.length === 0 ? (
                            <div style={{ textAlign: "center", padding: 60, color: COLORS.muted }}>Aucune opportunité trouvée.</div>
                        ) : (
                            <>
                                <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(280px, 1fr))", gap: 20, marginBottom: 24 }}>
                                    {opportunites.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE).map(item => (
                                        <Card key={item.id} item={item} onClick={setSelected}
                                            isFavorited={favoris.has(item.id)}
                                            onToggleFavorite={toggleFavorite} />
                                    ))}
                                </div>

                                {/* Pagination */}
                                <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", padding: "16px 0", borderTop: "1px solid #e2e8f0" }}>
                                    <div style={{ fontSize: 13, color: COLORS.muted }}>
                                        Page {currentPage} sur {Math.ceil(opportunites.length / ITEMS_PER_PAGE)}
                                    </div>
                                    <div style={{ display: "flex", gap: 8 }}>
                                        <button onClick={() => setCurrentPage(p => Math.max(1, p - 1))} disabled={currentPage === 1}
                                            style={{ padding: "8px 16px", borderRadius: 8, border: "1px solid #e2e8f0", background: currentPage === 1 ? "#f8fafc" : "#fff", color: currentPage === 1 ? COLORS.muted : "#1a3a5c", cursor: currentPage === 1 ? "not-allowed" : "pointer", fontWeight: 600, fontSize: 13 }}>
                                            ← Précédent
                                        </button>
                                        <button onClick={() => setCurrentPage(p => Math.min(Math.ceil(opportunites.length / ITEMS_PER_PAGE), p + 1))}
                                            disabled={currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE)}
                                            style={{ padding: "8px 16px", borderRadius: 8, border: "1px solid #e2e8f0", background: currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE) ? "#f8fafc" : COLORS.primary, color: currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE) ? COLORS.muted : "#fff", cursor: currentPage >= Math.ceil(opportunites.length / ITEMS_PER_PAGE) ? "not-allowed" : "pointer", fontWeight: 600, fontSize: 13 }}>
                                            Suivant →
                                        </button>
                                    </div>
                                </div>
                            </>
                        )}
                    </>
                )}
            </div>

            {/* ── FOOTER ─────────────────────────────────── */}
            <footer style={{ background: "#0f2540", borderTop: "1px solid rgba(255,255,255,0.08)", padding: "28px 40px", display: "flex", justifyContent: "space-between", alignItems: "center", flexWrap: "wrap", gap: 12, color: "#fff", fontSize: 13 }}>
                <div style={{ display: "flex", alignItems: "center", gap: 10, fontWeight: 800, fontSize: 16 }}>
                    <div style={{ width: 28, height: 28, borderRadius: 6, background: "linear-gradient(135deg, #1a3a5c, #009A44)", display: "flex", alignItems: "center", justifyContent: "center", fontSize: 14 }}>🔬</div>
                    VeilleSci<span style={{ color: "#c9a961" }}>BF</span>
                </div>
                <p style={{ margin: 0, color: "rgba(255,255,255,0.45)" }}>© {new Date().getFullYear()} VeilleSci Burkina — Tous droits réservés</p>
                <p style={{ margin: 0, color: "#4ade80" }}>🇧🇫 Fait avec ❤️ au Burkina Faso</p>
            </footer>

            <Modal item={selected} onClose={() => setSelected(null)} />
            <AIAssistant />
        </div>
    );
}