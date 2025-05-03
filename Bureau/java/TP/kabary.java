
public class kabary {

    public static void main(String[] args) {

        String[] mpikabary = new String[3];
        String[] village = new String[3];
        String[] heure = new String[3];
        int[] longueur = new int[3];
        double[] note1 = new double[3];
        double[] note2 = new double[3];
        double[] note3 = new double[3];
        String vainqueur = "";

        // Données
        mpikabary[0] = "Rakoto";
        village[0] = "Ambohimanga";
        heure[0] = "11:50";
        longueur[0] = 15;
        note1[0] = 17;
        note2[0] = 18;
        note3[0] = 19;

        mpikabary[1] = "Rabe";
        village[1] = "Antananarivo";
        heure[1] = "12:10";
        longueur[1] = 20;
        note1[1] = 12;
        note2[1] = 14;
        note3[1] = 9;

        mpikabary[2] = "Rasoa";
        village[2] = "Antananarivo";
        heure[2] = "12:30";
        longueur[2] = 20;
        note1[2] = 10;
        note2[2] = 12;
        note3[2] = 8;

        // Calcul des moyennes
        double[] moyenne = new double[3];
        for (int i = 0; i < mpikabary.length; i++) {
            moyenne[i] = (note1[i] + note2[i] + note3[i]) / 3;
            System.out.println("mpikabary " + mpikabary[i] + " (" + village[i] + ") à " + heure[i] + " -- moyenne : "
                    + moyenne[i]);
        }

        // Trouver le meilleur
        int meilleur = 0;
        if (moyenne[1] > moyenne[0]) {
            meilleur = 1;
        }
        if (moyenne[2] > moyenne[meilleur]) {
            meilleur = 2;
        }

        vainqueur = mpikabary[meilleur];
        System.out.println("\nMeilleur mpikabary : " + vainqueur + " (" + village[meilleur] + ") avec une moyenne de "
                + moyenne[meilleur]);

        // Vérifier les chevauchements
        for (int i = 0; i < 3; i++) {// 2 boucles pour comparer et eviter les doublons
            for (int j = i + 1; j < 3; j++) {

                char[] h1 = heure[i].toCharArray();// hakana an le heure ataoa anaty tableau
                // ohatra hoe "11:50" -> {'1', '1', ':', '5', '0'}
                char[] h2 = heure[j].toCharArray();
                // Conversion des heures en minutes
                // Exemple : "11:50" -> 11 * 60 + 50 = 710
                int heure1 = (h1[0] - '0') * 10 + (h1[1] - '0');// *10 pour reconstrure le dizaine */
                int minute1 = (h1[3] - '0') * 10 + (h1[4] - '0');// char donc atao - '0'
                int heure2 = (h2[0] - '0') * 10 + (h2[1] - '0');
                int minute2 = (h2[3] - '0') * 10 + (h2[4] - '0');

                int debut1 = heure1 * 60 + minute1;
                int debut2 = heure2 * 60 + minute2;
                int fin1 = debut1 + longueur[i];
                int fin2 = debut2 + longueur[j];

                if ((debut1 < fin2 && debut1 >= debut2) || (debut2 < fin1 && debut2 >= debut1)) {
                    System.out.println("Chevauchement détecté entre " + mpikabary[i] + " et " + mpikabary[j]);
                }
            }
        }

        // Calcul des moyennes des notes pour les discours courts et longs par jury
        double[] moyenneCourts = new double[3]; // Par jury
        double[] moyenneLongs = new double[3]; // Par jury 0,1,2 indice jurt
        int[] countCourtsParJury = new int[3];
        int[] countLongsParJury = new int[3];
        // Calcul des moyennes des notes pour les discours courts et longs
        // par jury de mjerena ra plus de 10min le kabary de ra ohatra long de jerena
        // note ameny ra betsaka noho le court
        // jereny hoe lava sa fohy de jereny moyenne an ze lava sy fohy
        for (int i = 0; i < mpikabary.length; i++) {
            if (longueur[i] <= 10) {
                moyenneCourts[0] += note1[i];
                countCourtsParJury[0]++;
                moyenneCourts[1] += note2[i];
                countCourtsParJury[1]++;
                moyenneCourts[2] += note3[i];
                countCourtsParJury[2]++;
            } else {
                moyenneLongs[0] += note1[i];
                countLongsParJury[0]++;
                moyenneLongs[1] += note2[i];
                countLongsParJury[1]++;
                moyenneLongs[2] += note3[i];
                countLongsParJury[2]++;
            }
        }
        // mijery moyene an le kabary long sy court teo
        for (int i = 0; i < 3; i++) {
            if (countCourtsParJury[i] > 0) {
                moyenneCourts[i] /= countCourtsParJury[i];
            }
            if (countLongsParJury[i] > 0) {
                moyenneLongs[i] /= countLongsParJury[i];
            }
        }

        System.out.println("\nMembres du jury qui donnent plus de notes en moyenne pour les discours courts :");
        for (int i = 0; i < 3; i++) {
            if (moyenneCourts[i] > moyenneLongs[i]) {
                System.out.println("Membre du jury " + (i + 1));
            }
        }
        // Calcul des moyennes des notes pour les discours terminés entre midi et 14h
        double[] moyenneMidi14h = new double[3]; // Par jury
        double[] moyenneAutres = new double[3]; // Par jury
        int[] countMidi14hParJury = new int[3];
        int[] countAutresParJury = new int[3];

        for (int i = 0; i < mpikabary.length; i++) {
            char[] h = heure[i].toCharArray();
            int heureDebut = (h[0] - '0') * 10 + (h[1] - '0');
            int minuteDebut = (h[3] - '0') * 10 + (h[4] - '0');
            int debut = heureDebut * 60 + minuteDebut;
            int fin = debut + longueur[i];
            // Vérification si le discours se termine entre midi et 14h
            // Exemple : 12:00 -> 12 * 60 + 00 = 720 de jerena hoe ao anatiny io ve de r tsy
            // ao de tsy anatiny le midi 14h
            if (fin >= 12 * 60 && fin <= 14 * 60) {
                moyenneMidi14h[0] += note1[i];
                countMidi14hParJury[0]++;
                moyenneMidi14h[1] += note2[i];
                countMidi14hParJury[1]++;
                moyenneMidi14h[2] += note3[i];
                countMidi14hParJury[2]++;
            } else {
                moyenneAutres[0] += note1[i];
                countAutresParJury[0]++;
                moyenneAutres[1] += note2[i];
                countAutresParJury[1]++;
                moyenneAutres[2] += note3[i];
                countAutresParJury[2]++;
            }
        }
        // Calcul des moyennes
        // pour les discours terminés entre midi et 14h
        for (int i = 0; i < 3; i++) {
            if (countMidi14hParJury[i] > 0) {
                moyenneMidi14h[i] /= countMidi14hParJury[i];
            }
            if (countAutresParJury[i] > 0) {
                moyenneAutres[i] /= countAutresParJury[i];
            }
        }

        System.out.println(
                "\nMembres du jury qui donnent plus de notes en moyenne pour les discours terminés entre midi et 14h :");
        for (int i = 0; i < 3; i++) {
            if (moyenneMidi14h[i] > moyenneAutres[i]) {
                System.out.println("Membre du jury " + (i + 1));
            }
        }

    }
}
