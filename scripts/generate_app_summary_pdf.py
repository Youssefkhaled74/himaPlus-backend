from pathlib import Path

from reportlab.lib import colors
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import ParagraphStyle, getSampleStyleSheet
from reportlab.lib.units import mm
from reportlab.platypus import ListFlowable, ListItem, Paragraph, SimpleDocTemplate, Spacer, Table, TableStyle


ROOT = Path(__file__).resolve().parents[1]
OUTPUT = ROOT / "output" / "pdf" / "app-summary-one-page.pdf"


def build_styles():
    styles = getSampleStyleSheet()
    styles.add(
        ParagraphStyle(
            name="TitleSmall",
            parent=styles["Title"],
            fontName="Helvetica-Bold",
            fontSize=18,
            leading=21,
            textColor=colors.HexColor("#0F172A"),
            spaceAfter=4,
        )
    )
    styles.add(
        ParagraphStyle(
            name="Section",
            parent=styles["Heading2"],
            fontName="Helvetica-Bold",
            fontSize=10,
            leading=12,
            textColor=colors.HexColor("#0F172A"),
            spaceBefore=4,
            spaceAfter=3,
        )
    )
    styles.add(
        ParagraphStyle(
            name="BodyTight",
            parent=styles["BodyText"],
            fontName="Helvetica",
            fontSize=8.2,
            leading=10,
            textColor=colors.HexColor("#334155"),
            spaceAfter=1,
        )
    )
    styles.add(
        ParagraphStyle(
            name="SmallNote",
            parent=styles["BodyText"],
            fontName="Helvetica",
            fontSize=7.2,
            leading=9,
            textColor=colors.HexColor("#64748B"),
        )
    )
    return styles


def bullet_list(items, style):
    return ListFlowable(
        [
            ListItem(Paragraph(item, style), leftIndent=0)
            for item in items
        ],
        bulletType="bullet",
        start="circle",
        leftIndent=10,
        bulletFontName="Helvetica",
        bulletFontSize=6,
        spaceBefore=0,
        spaceAfter=0,
    )


def main():
    OUTPUT.parent.mkdir(parents=True, exist_ok=True)
    styles = build_styles()
    doc = SimpleDocTemplate(
        str(OUTPUT),
        pagesize=A4,
        leftMargin=13 * mm,
        rightMargin=13 * mm,
        topMargin=11 * mm,
        bottomMargin=10 * mm,
    )

    story = []
    story.append(Paragraph("App Summary", styles["TitleSmall"]))
    story.append(
        Paragraph(
            "Repo-based snapshot of the Laravel app in <b>C:\\laragon\\www\\himaPlus_backend-main</b>.",
            styles["SmallNote"],
        )
    )
    story.append(Spacer(1, 4))

    left_col = []
    right_col = []

    left_col.append(Paragraph("What It Is", styles["Section"]))
    left_col.append(
        Paragraph(
            "A Laravel 10 application with web, admin-panel, and `/api` routes for a marketplace-style workflow around products, cart, orders, quotations, maintenance requests, offers, ratings, chat, and payments.",
            styles["BodyTight"],
        )
    )
    left_col.append(
        Paragraph(
            "The codebase supports both browser views and JWT-protected API clients, with email/SMS verification, admin management, and provider-specific flows.",
            styles["BodyTight"],
        )
    )

    left_col.append(Paragraph("Who It's For", styles["Section"]))
    left_col.append(
        Paragraph(
            "Primary persona: an authenticated customer/buyer who browses products or providers, adds items to cart, places direct orders or service requests, reviews offers, pays online, and tracks updates. The repo also includes provider (`user_type = 2`) and admin roles.",
            styles["BodyTight"],
        )
    )

    left_col.append(Paragraph("What It Does", styles["Section"]))
    left_col.append(
        bullet_list(
            [
                "Registers and authenticates users with verification codes, password reset, JWT auth, and account/profile updates.",
                "Lists products, categories, countries, providers, featured items, and offers; supports search, filtering, sorting, and ratings.",
                "Manages cart and favorites, then converts grouped cart items into provider-specific orders.",
                "Supports three order flows: direct product orders, quotation requests, and maintenance requests with file uploads.",
                "Lets providers submit offers and lets users accept/reject them, with timeline updates across order states.",
                "Includes in-app chat, notifications, email jobs, and Firebase push messaging for order and chat events.",
                "Provides online payment integration through Paymob, plus coupon, VAT, and order total handling.",
            ],
            styles["BodyTight"],
        )
    )

    right_col.append(Paragraph("How It Works", styles["Section"]))
    right_col.append(
        bullet_list(
            [
                "Routing: `routes/web.php` serves user/vendor browser flows, `routes/admin.php` serves the admin panel, and `routes/api.php` exposes public and authenticated API endpoints.",
                "Application layer: controllers under `App\\Http\\Controllers\\Api`, `Front`, and `Admin` orchestrate requests; some admin logic is delegated to repository classes under `app/Http/Repositories/Eloquent/Admin`.",
                "Domain/data: Eloquent models include `User`, `Product`, `Order`, `OrderItem`, `Offer`, `Cart`, `Favorite`, `Rating`, `Conversation`, `Message`, `Notification`, `Category`, `Country`, and `Info`, backed by migrations in `database/migrations`.",
                "Supporting services: `PaymobService` handles payment URLs/webhooks, `FairbaseService` sends Firebase push notifications and chat payloads, `ForJawalyService` is configured for SMS, and queued mail/SMS jobs deliver account and order messages.",
                "Flow: client request -> route middleware (`limitReq`, auth, role checks) -> controller validation/business logic -> Eloquent/repository persistence -> notifications/jobs/payment callbacks -> JSON or Blade response.",
            ],
            styles["BodyTight"],
        )
    )

    right_col.append(Paragraph("How To Run", styles["Section"]))
    right_col.append(
        bullet_list(
            [
                "Install PHP dependencies: `composer install`.",
                "Create local config from the template if needed: `.env.example` -> `.env`, then set MySQL and Paymob values used by the repo.",
                "Generate the app key: `php artisan key:generate`.",
                "Create the schema: `php artisan migrate`.",
                "Start the app: `php artisan serve` for Laravel; optionally run `npm install` and `npm run dev` for Vite assets.",
            ],
            styles["BodyTight"],
        )
    )

    right_col.append(Paragraph("Not Found In Repo", styles["Section"]))
    right_col.append(
        Paragraph(
            "No project-specific README or deployment guide was found. The exact product branding, official business description, seed data steps, and production runbook are not documented in this repo.",
            styles["BodyTight"],
        )
    )

    table = Table(
        [[left_col, right_col]],
        colWidths=[88 * mm, 88 * mm],
        hAlign="LEFT",
    )
    table.setStyle(
        TableStyle(
            [
                ("VALIGN", (0, 0), (-1, -1), "TOP"),
                ("LEFTPADDING", (0, 0), (-1, -1), 4),
                ("RIGHTPADDING", (0, 0), (-1, -1), 4),
                ("TOPPADDING", (0, 0), (-1, -1), 2),
                ("BOTTOMPADDING", (0, 0), (-1, -1), 0),
                ("LINEBEFORE", (1, 0), (1, 0), 0.5, colors.HexColor("#CBD5E1")),
            ]
        )
    )
    story.append(table)

    doc.build(story)
    print(OUTPUT)


if __name__ == "__main__":
    main()
