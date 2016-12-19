#include <cstdio>
#include <cstdlib>

#include "FelicaWrapper.h"

int main(void);
void error_routine(void);
void print_vector(char* title, unsigned char* vector, int length);



int main_loop() {
	structure_polling polling;
	unsigned char system_code[2] = { 0xFF, 0xFF };
	polling.system_code = system_code;
	polling.time_slot = 0x00;

	unsigned char number_of_cards = 0;

	structure_card_information card_information;
	unsigned char card_idm[8];
	unsigned char card_pmm[8];
	card_information.card_idm = card_idm;
	card_information.card_pmm = card_pmm;

	unsigned long timeout;
	get_polling_timeout(&timeout);
	printf("timeout: %lu\r\n", timeout);
	timeout = 2000;
	set_polling_timeout(timeout);

	int cnt = 1;
	while (1) {
		printf("%d\n", cnt);
		bool ok = polling_and_get_card_information(&polling, &number_of_cards, &card_information);
		if (ok) {
			print_vector("card IDm:", card_idm, sizeof(card_idm));
			print_vector("card PMm:", card_pmm, sizeof(card_pmm));
		}
		cnt++;
	}

	return 0;
}

int main(void)
{
	if (!initialize_library()) {
		fprintf(stderr, "Can't initialize library.\n");
		return EXIT_FAILURE;
	}
	printf("Complete initialize_library\r\n");

	if (!open_reader_writer_auto()) {
		fprintf(stderr, "Can't open reader writer.\n");
		return EXIT_FAILURE;
	}
	printf("Complete open_reader_writer_auto\r\n");

	main_loop();

	if (!close_reader_writer()) {
		fprintf(stderr, "Can't close reader writer.\n");
		return EXIT_FAILURE;
	}

	if (!dispose_library()) {
		fprintf(stderr, "Can't dispose library.\n");
		return EXIT_FAILURE;
	}

	return EXIT_SUCCESS;
}

void error_routine(void) {
	enumernation_felica_error_type felica_error_type;
	enumernation_rw_error_type rw_error_type;
	get_last_error_types(&felica_error_type, &rw_error_type);
	printf("felica_error_type: %d\n", felica_error_type);
	printf("rw_error_type: %d\n", rw_error_type);

	close_reader_writer();
	dispose_library();
}

void print_vector(char* title, unsigned char* vector, int length) {
	if (title != NULL) {
		fprintf(stdout, "%s ", title);
	}

	int i;
	for (i = 0; i < length - 1; i++) {
		fprintf(stdout, "%02x ", vector[i]);
	}
	fprintf(stdout, "%02x", vector[length - 1]);
	fprintf(stdout, "\n");
}